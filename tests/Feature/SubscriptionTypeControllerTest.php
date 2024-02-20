<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class SubscriptionTypeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;
    
    public function test_lists_subscriptions()
    {
        $response = $this->getJson('/api/subscriptions');

        $response->assertOk();

        $this->assertNotNull($response->json('data')[0]['id']);
    }
}
