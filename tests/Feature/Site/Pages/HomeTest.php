<?php

namespace Site\Pages;

use Illuminate\Foundation\Testing\DatabaseTransactions;
//use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use DatabaseTransactions;


    public function test_the_home_page_successfully_opens(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertSeeText(__('home.best_prices'));
    }
}
