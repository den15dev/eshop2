<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Categories\Requests\StoreCategoryRequest;
use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Admin\Categories\CategoryService as AdmCategoryService;
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
        $children = $categories->where('parent_id', $id);
//        $specs = $category->specifications->sortBy('sort');
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
        $request->flashSuccessMessage('Изменения сохранены');

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
