<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use App\Models\Handyman;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class QuoteControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_quotes()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();
        Quote::factory(3)->for($user)->for($handyman)->create();

        $response = $this->getJson('/api/quotes');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id', 'handyman_id']]]);
    }

    public function test_lists_quotes_with_pagination()
    {
        Quote::factory(20)->create();

        $response = $this->getJson('/api/quotes');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id', 'handyman_id']]]);
    }
    
    public function test_shows_a_single_quote()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $quote = Quote::factory()->for($user)->create();

        $response = $this->getJson('/api/quotes/'.$quote->id);
        
        $response->assertOk()
            ->assertJsonPath('data.id', $quote->id)
            ->assertJsonPath('data.user.id', $user->id);
    }

    public function test_can_create_a_quote()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/quotes', Quote::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id);

        $this->assertDatabaseHas('quotes', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_request_for_a_quote()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/quotes/client/'.$user->id, Quote::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id)
            ->assertJsonPath('data.requested', true);

        $this->assertDatabaseHas('quotes', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_respond_to_a_quote()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();
        // $quote = Quote::factory()->for($user)->for($handyman)->create();
        $quote = Quote::factory()->for($user)->for($handyman)->create(['requested' => true]);

        $this->actingAs($handyman);

        $response = $this->putJson('/api/quotes/'.$quote->id.'/respond', [
            'price' => 12345,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.price', 12345);
    }

    // public function test_can_not_respond_to_a_quote_that_is_not_requested()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $handyman = Handyman::factory()->create();
    //     // $quote = Quote::factory()->for($user)->for($handyman)->create();
    //     $quote = Quote::factory()->for($user)->for($handyman)->create();

    //     $this->actingAs($handyman);

    //     $response = $this->putJson('/api/quotes/'.$quote->id.'/respond', [
    //         'price' => 12345,
    //     ]);

    //     // * fluctuates between 400 & 403
    //     $response->assertStatus(403);
    //     $response->assertStatus(400);
    // }

    public function test_can_update_a_quote()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $quote = Quote::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/quotes/'.$quote->id, [
            'quote_details' => 'updated detail',
        ]);

        $response->assertOk();
            // ->assertJsonPath('data.quote_details', 'updated detail');
    }
    
    public function test_can_delete_a_quote()
    {
        $user = User::factory()->create();
        $quote = Quote::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/quotes/'.$quote->id);

        $response->assertOk();

        $this->assertSoftDeleted($quote);
    }
}
