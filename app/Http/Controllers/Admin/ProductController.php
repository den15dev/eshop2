<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Products\ProductService;
use App\Admin\Products\Requests\ProductRequest;
use App\Http\Controllers\Controller;
use App\Modules\Brands\Models\Brand;
use App\Modules\Categories\CategoryService;
use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Sku;
use Illuminate\Http\RedirectResponse;
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
        $unfinished = Product::whereDoesntHave('skus')->get();
        $categories = AdmCategoryService::sortToTree(CategoryService::getAll());

        $table_data = $this->getTableData($request);
        $state = $this->productService->getPageState($request->query());

        return view('admin.pages.products.index', array_merge(compact(
            'unfinished',
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

        $row_links = ProductService::ROW_LINKS;

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
            'row_links',
        );
    }


    public function edit(int $id): View
    {
        $product = Product::with('attributes.variants')->find($id);
        $max_skus = $this->productService->getSkuMaxNum($product->attributes);
        $languages = LanguageService::getAll();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $categories = $this->productService->getCategories(CategoryService::getAll());
        $skus = Sku::select('id', 'name')->where('product_id', $id)->orderBy('id')->get();

        return view('admin.pages.products.edit', compact(
            'product',
            'max_skus',
            'languages',
            'brands',
            'categories',
            'skus',
        ));
    }


    public function update(ProductRequest $request, int $id)
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

            $this->productService->moveProductToCategory($id, $category_id);

            $message = __('admin/products.messages.category_changed', ['category' => $new_category->name]);
        }

        $request->flashSuccessMessage($message);

        return back();
    }


    public function create(): View
    {
        $languages = LanguageService::getAll();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $categories = $this->productService->getCategories(CategoryService::getAll());

        return view('admin.pages.products.create', compact(
            'languages',
            'brands',
            'categories',
        ));
    }


    public function store(ProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $product = new Product();
        $product->name = $validated['name'];
        $product->category_id = $validated['category'];
        $product->brand_id = $validated['brand'];
        $product->save();

        $request->flashSuccessMessage(__('admin/products.messages.product_created', ['name' => $product->name]));

        return redirect()->route('admin.products.edit', $product->id);
    }


    public function destroy(int $id)
    {
        $product = Product::find($id);
        $skus_num = $this->productService->deleteProductImages($id);
        $product_name = $product->name;
        $product->delete();

        $message = $skus_num
            ? __('admin/products.messages.product_deleted', ['name' => $product_name, 'num' => $skus_num])
            : __('admin/products.messages.empty_product_deleted', ['name' => $product_name]);

        session()->flash('message', [
            'type' => 'success',
            'content' => $message,
            'align' => 'center',
        ]);

        return redirect()->route('admin.products');
    }
}
