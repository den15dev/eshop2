<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Brands\BrandService;
use App\Admin\IndexTable\IndexTableService;
use App\Http\Controllers\Controller;
use App\Modules\Brands\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly BrandService $brandService,
    ){}


    public function index(Request $request): View
    {
        $table_data = $this->getTableData($request);
        $state = $this->brandService->getPageState($request->query());

        return view('admin.pages.brands.index', array_merge(compact(
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = BrandService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = BrandService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->brandService->buildIndexQuery($request->query(), $this->tableService);
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
        $brand = Brand::find($id);

        return view('admin.pages.brands.edit', compact('brand'));
    }
}
