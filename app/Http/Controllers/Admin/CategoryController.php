<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Categories\Requests\StoreCategoryRequest;
use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Modules\Categories\Models\Category;
use App\Modules\Images\ImageService;
use App\Modules\Languages\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $languages = LanguageService::getActive();

        return view('admin.pages.categories.create', compact(
            'parent_id',
            'languages',
        ));
    }


    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $request->flashSuccessMessage('Новая категория создана');

        return redirect()->route('admin.categories');
    }


    public function edit(int $id)
    {
        $languages = LanguageService::getActive();
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


    public function update(StoreCategoryRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $message = __('admin/general.messages.changes_saved');

        $category = Category::find($id);
        $old_slug = $category->slug;
        $old_parent_id = $category->parent_id;
        $old_sort = $category->sort;

        if ($request->has('name')) {
            $category->update($validated);

            $dir = storage_path(ImageService::LOCAL_DIR) . '/' . Category::IMG_DIR;
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
        session()->flash('message', [
            'type' => 'success',
            'content' => 'Категория успешно удалена',
            'align' => 'center',
        ]);

        return redirect()->route('admin.categories');
    }
}
