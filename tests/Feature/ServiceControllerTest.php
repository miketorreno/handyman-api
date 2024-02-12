<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class ServiceControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_it_lists_services()
    {
        $response = $this->get('/api/services');

        $response->assertOk();

        $this->assertNotNull($response->json('data')[0]['id']);
    }
}
