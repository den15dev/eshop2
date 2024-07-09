<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Products\ProductService;
use App\Admin\Products\Requests\SkuRequest;
use App\Http\Controllers\Controller;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Languages\LanguageService;
use App\Admin\Promos\PromoService;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Sku;
use DragonCode\Support\Facades\Helpers\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkuController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ){}


    public function edit(int $id): View
    {
        $sku = $this->productService->getSku($id);
        $languages = LanguageService::getAll();
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


    public function create(Request $request): View
    {
        $product = Product::join('categories', 'products.category_id', 'categories.id')
            ->select(
                'products.*',
                'categories.name as category_name',
            )
            ->with('attributes.variants:id,attribute_id,name')
            ->find($request->query('product_id'));

        abort_unless($product, 404);

        $languages = LanguageService::getAll();
        $currencies = CurrencyService::getAll();
        $promos = PromoService::getAllPromos();
        $final_prices = $this->productService->getSkuFinalPrices(0, CurrencyService::$cur_currency->id, null, null);
        $category_specs = $this->productService->getCategorySpecs($product->category_id);

        return view('admin.pages.skus.create', compact(
            'product',
            'languages',
            'currencies',
            'promos',
            'final_prices',
            'category_specs',
        ));
    }


    public function update(SkuRequest $request, int $id)
    {
        $updated = [];
        $flash_message = '';

        if ($request->has('available_from')) {
            $updated = $request->validated();
        }

        if ($request->has('attributes')) {
            if (!$this->productService->validateSkuAttributes($id, $request->product_id, $request['attributes'])) {
                return back()->withInput()->with('attributes_error', __('admin/skus.errors.sku_attributes_error'));
            }

            $this->productService->updateSkuAttributes($id, $request['attributes']);
            $flash_message = __('admin/skus.messages.attributes_updated');
        }

        if ($request->has('sku')) {
            $updated = $request->validated();
            $updated['slug'] = Str::slug($request->validated('name')[app()->getFallbackLocale()]);
        }

        if ($request->has('old_images')) {
            $validated = $request->validated();

            $old_images = isset($validated['old_images']) ? json_decode($validated['old_images']) : [];
            $new_images = isset($validated['new_images']) ? json_decode($validated['new_images']) : [];
            $image_file = $request->file('image');

            $this->productService->updateSkuImages($id, $old_images, $new_images, $image_file);
            $flash_message = __('admin/skus.messages.images_updated');
        }

        if (count($updated)) {
            Sku::firstWhere('id', $id)->update($updated);
            $flash_message = __('admin/skus.messages.sku_updated');
        }

        if (!empty($flash_message)) $request->flashSuccessMessage($flash_message);

        return back();
    }


    public function store(SkuRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $sku = new Sku();
        $sku->product_id = $request->product_id;
        $sku->name = $validated['name'];
        $sku->slug = Str::slug($validated['name'][app()->getFallbackLocale()]);
        $sku->sku = $validated['sku'];
        $sku->short_descr = $validated['short_descr'];
        $sku->description = $validated['description'];
        $sku->currency_id = $validated['currency_id'];
        $sku->price = $validated['price'];
        $sku->discount = $validated['discount'] ?: null;
        $sku->images = null;
        $sku->available_from = $validated['available_from'];
        $sku->available_until = $validated['available_until'];
        $sku->promo_id = $validated['promo_id'];
        $sku->save();

        if ($request->has('attributes')) {
            $attributes = $request['attributes'];
            if (!$this->productService->validateSkuAttributes($sku->id, $sku->product_id, $attributes)) {
                return back()->withInput()->with('attributes_error', __('admin/skus.errors.sku_attributes_error'));
            }

            foreach ($attributes as $variant_id) {
                $sku->variants()->attach($variant_id);
            }
        }

        if (isset($validated['specs'])) {
            $specs = $validated['specs'];
            foreach ($specs as $spec_id => $fields) {
                $sku->specifications()->attach($spec_id, ['spec_value' => $fields]);
            }
        }

        if (isset($validated['images']) && count($validated['images'])) {
            $images = $validated['images'];
            $images_arr = [];

            foreach ($images as $index => $image) {
                $this->productService->saveSkuImage($sku->id, $index, $image);
                $images_arr[] = sprintf('%02d', $index);
            }

            $sku->update(['images' => $images_arr]);
        }

        $request->flashSuccessMessage(__('admin/products.messages.sku_added', ['name' => $sku->name]));

        return redirect()->route('admin.products.edit', $sku->product_id);
    }


    public function destroy(int $id)
    {
        $sku = Sku::find($id);
        $this->productService->deleteSkuImages($id);
        $sku_name = $sku->name;
        $sku->delete();

        $message = __('admin/skus.messages.sku_deleted', ['name' => $sku_name]);

        session()->flash('message', [
            'type' => 'success',
            'content' => $message,
            'align' => 'center',
        ]);

        return redirect()->route('admin.products');
    }
}
