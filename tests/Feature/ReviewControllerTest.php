<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Handyman;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class ReviewControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_handymen_reviews()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();
        $reviews = $handyman->reviews()->create(['user_id' => $user->id]);
        // $handyman->reviews()->create();

        // $handyman = Handyman::factory()->for($user)->hasReviews(3)->create();

        // dd($reviews);

        // $response = $this->getJson('/api/handymen/'.$handyman->id.'/reviews');

        // dd($response);

        // $response->assertOk();
            // ->assertJsonCount(3, 'data')
            // ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
        // $this->assertNotNull($response->json('data')[0]['id']);
    }
}
