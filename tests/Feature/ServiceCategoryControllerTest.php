<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class ServiceCategoryControllerTest extends TestCase
{
    use LazilyRefreshDatabase;
    
    public function test_it_lists_categories()
    {
        $response = $this->get('/api/categories');

        $response->assertOk();

        $this->assertNotNull($response->json('data')[0]['id']);
    }
}
