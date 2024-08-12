<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example 2.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertSeeText('Popular');
    }
}
