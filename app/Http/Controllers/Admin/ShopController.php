<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Shops\Requests\ShopRequest;
use App\Admin\Shops\ShopService;
use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Shops\Models\Shop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __construct(
        private readonly IndexTableService $tableService,
        private readonly ShopService $shopService,
    ){}


    public function index(Request $request): View
    {
        $table_data = $this->getTableData($request);
        $state = $this->shopService->getPageState($request->query());

        return view('admin.pages.shops.index', array_merge(compact(
            'state',
        ), $table_data));
    }


    public function table(Request $request): View
    {
        return view('admin.includes.index-table', $this->getTableData($request));
    }


    private function getTableData(Request $request): array
    {
        $table_name = ShopService::TABLE_NAME;
        $this->tableService->initTable($table_name, $request->query());

        $col_cookie_name = ShopService::COLUMNS_COOKIE;
        $cookie = $request->cookie($col_cookie_name);
        $column_prefs = $cookie ? json_decode($cookie) : null;

        $row_links = ShopService::ROW_LINKS;

        $column_list = $this->tableService->getColumnList($column_prefs);
        $per_page_list = IndexTableService::getPerPageList();

        $current_columns = $this->tableService->getCurrentColumns($column_prefs);

        $query = $this->shopService->buildIndexQuery($request->query(), $this->tableService);
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


    public function create(): View
    {
        $languages = LanguageService::getAll();
        $shops_count = Shop::count();
        $opening_hours_text = $this->shopService->getOpeningHoursForEdit();

        return view('admin.pages.shops.create', compact(
            'languages',
            'shops_count',
            'opening_hours_text',
        ));
    }


    public function edit(int $id): View
    {
        $shop = Shop::withCount('orders')->find($id);
        $languages = LanguageService::getAll();
        $shops_count = Shop::count();
        $opening_hours_text = $this->shopService->getOpeningHoursForEdit($shop->opening_hours);

        return view('admin.pages.shops.edit', compact(
            'shop',
            'languages',
            'shops_count',
            'opening_hours_text',
        ));
    }


    public function store(ShopRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $shop = new Shop();
        $shop->name = $validated['name'];
        $shop->address = $validated['address'];
        $shop->location = $this->shopService->parseLocation($validated['location']);
        $shop->opening_hours = $this->shopService->parseOpeningHours($validated['opening_hours']);
        $shop->info = $validated['info'];
        $shop->sort = $this->shopService->updateOrder($validated['sort']);
        $shop->is_active = $validated['is_active'] ?? false;
        $shop->save();

        $request->flashSuccessMessage(__('admin/shops.messages.shop_added', ['name' => $shop->name]));

        return redirect()->route('admin.shops');
    }


    public function update(ShopRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();

        $this->shopService->updateOrder($validated['sort'], $request->sort_old, $id);
        $validated['opening_hours'] = $this->shopService->parseOpeningHours($validated['opening_hours']);
        $validated['location'] = $this->shopService->parseLocation($validated['location']);

        Shop::find($id)->update($validated);

        $request->flashSuccessMessage(__('admin/general.messages.changes_saved'));

        return back();
    }


    public function destroy(int $id)
    {
        $shop = Shop::find($id);
        $sort = $shop->sort;
        $shop->delete();

        Shop::where('sort', '>', $sort)->decrement('sort');

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/shops.messages.deleted', ['name' => $shop->name]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.shops');
    }
}
