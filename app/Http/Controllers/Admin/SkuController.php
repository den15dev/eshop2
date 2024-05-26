<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Products\ProductService;
use App\Admin\Products\Requests\StoreSkuRequest;
use App\Http\Controllers\Controller;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Languages\LanguageService;
use App\Admin\Promos\PromoService;
use App\Modules\Products\Models\Sku;
use Illuminate\View\View;

class SkuController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ){}


    public function edit(int $id): View
    {
        $sku = $this->productService->getSku($id);
        $languages = LanguageService::getActive();
        $currencies = CurrencyService::getAll();
        $promos = PromoService::getAllPromos();
        $final_prices = $this->productService->getSkuFinalPrices(
            $sku->price,
            $sku->currency_id,
            $sku->discount,
            $sku->promo_id
        );
        $category_specs = $this->productService->getCategorySpecs($sku->product->category_id);

        return view('admin.pages.skus.edit', compact(
            'sku',
            'languages',
            'currencies',
            'promos',
            'final_prices',
            'category_specs',
        ));
    }


    public function create(): View
    {
        return view('admin.pages.skus.create');
    }


    public function update(StoreSkuRequest $request, int $id)
    {
        $updated = [];
        $flash_message = '';

        if ($request->has('available_from')) {
            $updated = $request->validated();
        }

        if ($request->has('attributes')) {
            if (!$this->productService->validateSkuAttributes($id, $request->product_id, $request['attributes'])) {
                return back()->withInput()->with('attributes_error', __('admin/products.errors.sku_attributes_error'));
            }

            $this->productService->updateSkuAttributes($id, $request['attributes']);
            $flash_message = __('admin/products.messages.attributes_updated');
        }

        if ($request->has('sku')) {
            $updated = $request->validated();
        }

        if ($request->has('images')) {
            $validated = $request->validated();

            $old_images = isset($validated['old_images']) ? json_decode($validated['old_images']) : [];
            $new_images = isset($validated['images']) ? json_decode($validated['images']) : [];
            $image_file = $request->file('image');

            $this->productService->updateSkuImages($id, $old_images, $new_images, $image_file);
            $flash_message = __('admin/products.messages.images_updated');
        }

        if (count($updated)) {
            Sku::firstWhere('id', $id)->update($updated);
            $flash_message = __('admin/products.messages.sku_updated');
        }

        if (!empty($flash_message)) $request->flashSuccessMessage($flash_message);

        return back();
    }


    public function destroy(int $id)
    {
        return redirect()->route('admin.products');
    }
}
