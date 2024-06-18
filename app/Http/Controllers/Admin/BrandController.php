<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Brands\BrandService;
use App\Admin\Brands\Requests\StoreBrandRequest;
use App\Admin\IndexTable\IndexTableService;
use App\Http\Controllers\Controller;
use App\Modules\Brands\Models\Brand;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Sku;
use Illuminate\Http\RedirectResponse;
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


    public function create(): View
    {
        $languages = LanguageService::getAll();

        return view('admin.pages.brands.create', compact(
            'languages',
        ));
    }


    public function edit(int $id): View
    {
        $brand = Brand::find($id);
        $languages = LanguageService::getAll();
        $product_num = Product::where('brand_id', $id)->count();
        $sku_num = Sku::join('products', 'skus.product_id', 'products.id')
            ->where('products.brand_id', $id)
            ->count();

        return view('admin.pages.brands.edit', compact(
            'brand',
            'languages',
            'product_num',
            'sku_num',
        ));
    }


    public function store(StoreBrandRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $brand = new Brand();
        $brand->name = $validated['name'];
        $brand->slug = $validated['slug'];
        $brand->description = $validated['description'];
        $brand->save();

        if ($request->has('image')) {
            $this->brandService->saveImage($validated['slug'], $request->file('image'));
        }

        $request->flashSuccessMessage(__('admin/brands.messages.brand_added', ['name' => $brand->name]));

        return redirect()->route('admin.brands');
    }


    public function update(StoreBrandRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $brand = Brand::find($id);
        $old_slug = $brand->slug;

        if ($request->has('name')) {
            $brand->update($validated);
            $this->brandService->renameImage($old_slug, $validated['slug']);
        }

        if ($request->has('image')) {
            $this->brandService->saveImage($old_slug, $request->file('image'));
        }

        $request->flashSuccessMessage(__('admin/general.messages.changes_saved'));

        return back();
    }


    public function destroy(int $id)
    {
        $brand = Brand::find($id);
        $product_num = Product::where('brand_id', $id)->count();

        if ($product_num) {
            session()->flash('message', [
                'type' => 'warning',
                'content' => __('admin/brands.messages.not_empty'),
                'align' => 'center',
            ]);

            return back();
        }

        $brand->delete();
        $this->brandService->deleteImage($brand->slug);

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/brands.messages.deleted', ['name' => $brand->name]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.brands');
    }
}
