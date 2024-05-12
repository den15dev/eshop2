<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Products\ProductService;
use App\Admin\Products\Requests\ProductAjaxRequest;
use App\Admin\Products\Requests\StoreProductRequest;
use App\Http\Controllers\Controller;
use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\CategoryService;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Sku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly ProductService $productService,
    ){}


    public function index(Request $request): View
    {
        $categories = CategoryService::getAll();

        $table_data = $this->getTableData($request);
        $state = $this->productService->getPageState($request->query());

        return view('admin.pages.products.index', array_merge(compact(
            'categories',
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = ProductService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = ProductService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->productService->buildIndexQuery($request->query(), $this->tableService);
        $items = $query->paginate(IndexTableService::$per_page);

        return compact(
            'column_list',
            'col_cookie_name',
            'per_page_list',
            'table_name',
            'current_columns',
            'items',
        );
    }


    public function edit(int $id): View
    {
        $product = Product::with('attributes.variants')->find($id);
        $languages = LanguageService::getActive();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $categories = CategoryService::getAll();
        $skus = Sku::select('id', 'name')->where('product_id', $id)->orderBy('id')->get();

        return view('admin.pages.products.edit', compact(
            'product',
            'languages',
            'brands',
            'categories',
            'skus',
        ));
    }


    public function update(StoreProductRequest $request, int $id)
    {
        $message = 'Something went wrong';
        $validated = $request->validated();

        if ($request->has('name')) {
            $name_json = json_encode($validated['name'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            Product::where('id', $id)
                ->update([
                    'name' => $name_json,
                    'brand_id' => $validated['brand'],
                ]);

            $message = __('admin/products.messages.updated');
        }

        if ($request->has('category')) {
            $category_id = $validated['category'];
            $new_category = Category::find($category_id);

            $this->productService->moveToCategory($id, $category_id);

            $message = __('admin/products.messages.category_changed', ['category' => $new_category->name]);
        }

        $request->flashSuccessMessage($message);

        return back();
    }


    public function create(): View
    {
        return view('admin.pages.products.create');
    }


    public function destroy(int $id)
    {
        return redirect()->route('admin.products');
    }
}
