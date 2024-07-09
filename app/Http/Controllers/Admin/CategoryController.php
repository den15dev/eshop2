<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Categories\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly AdmCategoryService $admCategoryService,
    ){}


    public function index(CategoryService $categoryService)
    {
        $categories = $categoryService->buildCategoryTree();

        return view('admin.pages.categories.index', compact(
            'categories',
        ));
    }


    public function create(Request $request): View
    {
        $parent_id = $request->query('parent_id');
        $languages = LanguageService::getAll();
        $categories = $this->admCategoryService->getParentCategoryList(CategoryService::getAll());

        return view('admin.pages.categories.create', compact(
            'parent_id',
            'languages',
            'categories',
        ));
    }


    public function store(CategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $parent = Category::find($request->parent_id);
        $children_num = Category::where('parent_id', $request->parent_id)->count();

        $category = new Category();
        $category->name = $validated['name'];
        $category->slug = $validated['slug'];
        $category->parent_id = $request->parent_id;
        $category->level = $parent?->level + 1;
        $category->sort = $children_num + 1;
        $category->save();

        $request->flashSuccessMessage(__('admin/categories.messages.category_created', ['name' => $category->name]));

        return redirect()->route('admin.categories');
    }


    public function edit(int $id)
    {
        $languages = LanguageService::getAll();
        $categories = $this->admCategoryService->getParentCategoryList(CategoryService::getAll(), $id);
        $category = $categories->firstWhere('id', $id);
        $parent = $categories->firstWhere('id', $category->parent_id);
        $children = $categories->where('parent_id', $id)->sortBy('sort');
        $specs = $category
            ->specifications()
            ->withCount('skus')
            ->orderBy('sort')
            ->get();

        return view('admin.pages.categories.edit', compact(
            'languages',
            'categories',
            'category',
            'parent',
            'children',
            'specs',
        ));
    }


    public function update(CategoryRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $message = __('admin/general.messages.changes_saved');

        $category = Category::find($id);
        $old_slug = $category->slug;
        $old_parent_id = $category->parent_id;
        $old_sort = $category->sort;

        if ($request->has('name')) {
            $category->update($validated);

            $dir = Storage::disk('images')->path(Category::IMG_DIR);
            if (file_exists($dir . '/' . $old_slug . '.jpg')) {
                rename($dir . '/' . $old_slug . '.jpg', $dir . '/' . $validated['slug'] . '.jpg');
            }
        }

        if ($request->has('parent_id') && $request->parent_id != $old_parent_id) {
            $new_sort = Category::where('parent_id', $request->parent_id)->count() + 1;
            $new_parent = Category::firstWhere('id', $request->parent_id);
            $new_level = $new_parent->level + 1;

            $category->update([
                'parent_id' => $request->parent_id,
                'level' => $new_level,
                'sort' => $new_sort,
            ]);

            Category::where('parent_id', $old_parent_id)
                ->where('sort', '>', $old_sort)
                ->decrement('sort');

            $message = __('admin/categories.messages.category_moved', ['name' => $new_parent->name]);
        }

        if ($request->has('children_order') && $request->children_order !== $request->old_children_order) {
            $children_order = json_decode($request->children_order);

            foreach ($children_order as $key => $child_id) {
                Category::firstWhere('id', $child_id)->update(['sort' => $key + 1]);
            }

            $message = __('admin/categories.messages.order_changed');
        }

        if ($request->has('image')) {
            $image_file = $request->file('image');
            $this->admCategoryService->saveImage($old_slug, $image_file);
            $message = __('admin/categories.messages.image_saved');
        }

        $request->flashSuccessMessage($message);

        return back();
    }


    public function destroy(int $id)
    {
        $category = Category::find($id);
        $product_num = Product::where('category_id', $id)->count();
        $children_num = Category::where('parent_id', $id)->count();

        if ($product_num || $children_num) {
            session()->flash('message', [
                'type' => 'warning',
                'content' => __('admin/categories.messages.not_empty'),
                'align' => 'center',
            ]);

            return back();
        }

        DB::beginTransaction();

        try {
            Category::where('parent_id', $category->parent_id)
                ->where('sort', '>', $category->sort)
                ->decrement('sort');

            $category->delete();
            $this->admCategoryService->deleteImage($category->slug);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('events')->info('An exception caught while deleting the category ' . $category->name . ': ' . $e->getMessage());
            abort(500);
        }

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/categories.messages.deleted', ['name' => $category->name]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.categories');
    }
}
