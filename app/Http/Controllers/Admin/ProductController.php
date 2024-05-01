<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Products\ProductService;
use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly IndexTableService $tableService,
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
        $col_cookie_name = ProductService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $table_name = ProductService::TABLE_NAME;

        $columns = $this->productService->getColumns($request->query());
        $column_list = $this->tableService->getColumnList($columns, $column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($columns, $column_prefs);

        $query = $this->productService->getSkusQuery($request->query());
        $skus = $query->paginate(IndexTableService::$per_page);

        return compact(
            'column_list',
            'col_cookie_name',
            'per_page_list',
            'table_name',
            'current_columns',
            'skus',
        );
    }


    public function edit(int $id): View
    {
        $product = Product::find($id);

        return view('admin.pages.products.edit', compact('product'));
    }


    public function create(): View
    {
        return view('admin.pages.products.create');
    }
}
