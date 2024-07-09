<?php

namespace App\Http\Controllers\Admin;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Promos\PromoService;
use App\Admin\Promos\Requests\PromoRequest;
use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Promos\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        $status = $this->promoService->getStatusText($promo->starts_at, $promo->ends_at);
        $skus = $promo->skus;

        return view('admin.pages.promos.edit', compact(
            'promo',
            'languages',
            'status',
            'skus',
        ));
    }


    public function store(PromoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $promo = new Promo();
        $promo->name = $validated['name'];
        $promo->slug = Str::slug($validated['name'][app()->getFallbackLocale()]);
        $promo->starts_at = $validated['starts_at'];
        $promo->ends_at = $validated['ends_at'];
        $promo->description = $validated['description'];
        $promo->discount = $validated['discount'];
        $promo->save();

        $this->promoService->saveImages($promo->id, $request->image, $promo->slug);
        $this->promoService->addSkus($validated['sku_ids'], $promo->id);

        $request->flashSuccessMessage(__('admin/promos.messages.promo_added', ['name' => $promo->name]));

        return redirect()->route('admin.promos');
    }


    public function update(PromoRequest $request, int $id): RedirectResponse
    {
        $validated = $request->validated();
        $message = __('admin/general.messages.changes_saved');

        if ($request->has('name')) {
            $new_slug = Str::slug($validated['name'][app()->getFallbackLocale()]);
            $validated['slug'] = $new_slug;

            Promo::find($id)->update($validated);

            $this->promoService->updateImageNames($id, $request->old_slug, $new_slug);

        } elseif ($request->has('image')) {
            $this->promoService->saveImages($id, $request->image, $request->slug);
            $message = __('admin/promos.messages.images_updated');

        } elseif ($request->has('sku_ids')) {
            $sku_num = $this->promoService->addSkus($request->sku_ids, $id);
            $message = __('admin/promos.messages.skus_added', ['num' => $sku_num]);
        }

        $request->flashSuccessMessage($message);

        return back();
    }


    public function destroy(int $id)
    {
        $promo = Promo::find($id);
        $promo->delete();
        $this->promoService->deleteImages($id);

        session()->flash('message', [
            'type' => 'info',
            'content' => __('admin/promos.messages.deleted', ['name' => $promo->name]),
            'align' => 'center',
        ]);

        return redirect()->route('admin.promos');
    }
}
