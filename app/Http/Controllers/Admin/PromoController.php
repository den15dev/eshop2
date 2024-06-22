<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Promos\PromoService;
use App\Admin\Promos\Requests\StorePromoRequest;
use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Sku;
use App\Modules\Promos\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly PromoService $promoService,
    ){}


    public function index(Request $request): View
    {
        $table_data = $this->getTableData($request);
        $state = $this->promoService->getPageState($request->query());

        return view('admin.pages.promos.index', array_merge(compact(
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = PromoService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = PromoService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->promoService->buildIndexQuery($request->query(), $this->tableService);
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

        return view('admin.pages.promos.create', compact(
            'languages',
        ));
    }


    public function edit(int $id): View
    {
        $promo = Promo::find($id);
        $languages = LanguageService::getAll();
        $status = $this->promoService->getStatusText($promo);
        $skus = $promo->skus;

        return view('admin.pages.promos.edit', compact(
            'promo',
            'languages',
            'status',
            'skus',
        ));
    }


    public function store(StorePromoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $promo = new Promo();

        $request->flashSuccessMessage(__('admin/brands.messages.brand_added', ['name' => $promo->name]));

        return redirect()->route('admin.promos');
    }


    public function update(StorePromoRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $promo = Promo::find($id);

        $request->flashSuccessMessage(__('admin/general.messages.changes_saved'));

        return back();
    }


    public function destroy(int $id)
    {
        $promo = Promo::find($id);

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/brands.messages.deleted', ['name' => $promo->name]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.promos');
    }
}
