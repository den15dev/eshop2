<?php

namespace Site;

use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\Enums\ProductSorting;
use App\Modules\Categories\Models\Category;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use DatabaseTransactions;


    public function test_catalog_page(): void
    {
        $response = $this->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSee('catalog-page-wrap');
    }


    public function test_catalog_page_with_filters_applied(): void
    {
        $skus = Sku::select(
                'skus.id',
                'skus.name',
            )
            ->with('specifications', function ($query) {
                $query->where('is_filter', true);
            })
            ->limit(2)
            ->get();

        $names = [];
        $query = [];
        foreach ($skus as $sku) {
            $names[] = $sku->name;

            foreach ($sku->specifications as $key => $spec) {
                if ($key > 1) break;

                $query['specs[' . $spec->id . ']'][] = $spec->pivot->spec_value;
            }
        }

        $params = array_merge(['category' => 'cpu'], $query);

        $response = $this->get(route('catalog', $params));

        $response->assertStatus(200);
        foreach ($names as $name) {
            $response->assertSeeText($name);
        }
    }


    public function test_catalog_page_sorting_cheap_first(): void
    {
        $skus = Sku::select(
                'skus.id',
                'skus.slug',
                'skus.code',
                'skus.name',
                'skus.currency_id',
                'skus.price',
            )
            ->get();

        $skus->each(function (Sku $sku) {
            $sku->price_converted = Price::from($sku->price, $sku->currency_id)->converted;
        });

        $skus = $skus->sortBy('price_converted');
        $first = $skus->slice(0, 1)->first();
        $last = $skus->slice(11, 1)->first();

        $response = $this->withCookie(CatalogService::PREF_COOKIE, '["' . ProductSorting::Cheap->value . '",12,1]')
            ->disableCookieEncryption()
            ->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSeeTextInOrder([$first->name, $last->name]);
    }


    public function test_catalog_page_24_items_output(): void
    {
        $skus = Sku::select(
            'skus.id',
            'skus.name',
            )
            ->limit(24)
            ->get();

        $names = $skus->pluck('name')->toArray();

        $response = $this->withCookie(CatalogService::PREF_COOKIE, '["' . ProductSorting::New->value . '",24,1]')
            ->disableCookieEncryption()
            ->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSeeText($names);
    }


    public function test_catalog_page_row_items_layout(): void
    {
        $response = $this->withUnencryptedCookie(CatalogService::PREF_COOKIE, '["' . ProductSorting::New->value . '",12,2]')
            ->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSee('class="product-row"', false);
    }


    public function test_catalog_page_with_categories(): void
    {
        $cat = Category::where('level', 1)->first();

        $response = $this->get(route('catalog', $cat->slug));

        $response->assertStatus(200);
        $response->assertSee('category-card');
    }


    public function test_out_of_stock_skus_not_shown(): void
    {
        $sku = Sku::orderBy('skus.created_at', 'desc')->first();

        $response = $this->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSeeText($sku->name);

        $sku->update([
            'available_from' => now()->subDay(3),
            'available_until' => now()->subDay(),
        ]);

        $response = $this->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertDontSeeText($sku->name);
    }


    public function test_scheduled_skus_not_shown(): void
    {
        $sku = Sku::orderBy('skus.created_at', 'desc')->first();

        $response = $this->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertSeeText($sku->name);

        $sku->update([
            'available_from' => now()->addDay(),
            'available_until' => null,
        ]);

        $response = $this->get(route('catalog', 'cpu'));

        $response->assertStatus(200);
        $response->assertDontSeeText($sku->name);
    }
}
