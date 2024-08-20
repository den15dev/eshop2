<?php

namespace Site\Pages;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic test example 3.
     */
    public function test_the_home_page_returns_200(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertSeeText('Best Prices');
    }
}
