<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\YardSale;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class YardSaleControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function test_lists_yard_sales_that_belong_to_a_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        YardSale::factory()->for($user)->count(2)->create();
        YardSale::factory()->count(3)->create();

        $response = $this->getJson('/api/yardsales?'.http_build_query([
                'user' => $user->id
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.user.id', $user->id)
            ->assertJsonPath('data.1.user.id', $user->id)
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['id', 'title', 'description']]]);
    }
    
    public function test_shows_a_single_yard_sale()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $yardSale = YardSale::factory()->for($user)->create();

        $response = $this->getJson('/api/yardsales/'.$yardSale->id);
        // dd($response);

        $response->assertOk();
            // ->assertJsonPath('data.user_id', $user->id);
    }

    public function test_can_create_yard_sale()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/yardsales', YardSale::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user_id', $user->id);
        $this->assertDatabaseHas('yard_sales', [
            'id' => $response->json('data.id')
        ]);
    }
    
    public function test_can_update_yard_sale()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $yardSale = YardSale::factory()->for($user)->create();

        // $this->actingAs($user, ['yardsale.update']);
        $this->actingAs($user);
        Sanctum::actingAs($user, ['yardsale.update']);

        $response = $this->putJson('/api/yardsales/'.$yardSale->id, [
            'title' => 'Updated YardSale',
        ]);

        // dd($response);

        $response->assertOk();
            // ->assertJsonPath('data.title', 'Updated YardSale');
    }

    public function test_does_not_allow_updating_if_scope_is_not_provided()
    {
        $user = User::factory()->create();
        $yardSale = YardSale::factory()->create();

        $this->actingAs($user, []);

        $response = $this->putJson('/api/yardsales/'.$yardSale->id);

        $response->assertForbidden();
    }
    
    public function test_can_delete_yard_sale()
    {
        $user = User::factory()->create();
        $yardSale = YardSale::factory()->for($user)->create();

        // $this->actingAs($user, ['yardsale.delete']);
        $this->actingAs($user);
        Sanctum::actingAs($user, ['yardsale.delete']);

        $response = $this->deleteJson('/api/yardsales/'.$yardSale->id);

        $response->assertOk();

        // $this->assertSoftDeleted($yardSale);
    }
    
    // public function test_can_not_delete_yard_sale_that_does_not_belong_to_user()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $anotherUser = User::factory()->create();
    //     $yardSale = YardSale::factory()->for($anotherUser)->create();

    //     // $this->actingAs($user, ['yardsale.delete']);
    //     $this->actingAs($user);
    //     Sanctum::actingAs($user, ['yardsale.delete']);

    //     $response = $this->deleteJson('/api/yardsales/'.$yardSale->id);

    //     $response->assertStatus(403);
    // }

    public function test_does_not_allow_deleting_if_scope_is_not_provided()
    {
        $user = User::factory()->create();
        $yardSale = YardSale::factory()->create();

        $this->actingAs($user, []);

        $response = $this->deleteJson('/api/yardsales/'.$yardSale->id);

        $response->assertForbidden();
    }
}
