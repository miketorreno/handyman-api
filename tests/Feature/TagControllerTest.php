<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class TagControllerTest extends TestCase
{
    use LazilyRefreshDatabase;
    
    public function test_lists_tags()
    {
        $response = $this->getJson('/api/tags');

        $response->assertOk();

        $this->assertNotNull($response->json('data')[0]['id']);
    }
}
