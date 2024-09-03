<?php

namespace Site;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_page(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSeeText(__('home.best_prices'));
    }
}
