<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class EventControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_events()
    {
        $user = User::factory()->create();
        $events = Event::factory(3)->for($user)->create();

        $response = $this->getJson('/api/events');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]])
            ->assertJsonPath('data.0.user.id', $user->id);
    }

    public function test_lists_events_with_pagination()
    {
        Event::factory(20)->create();

        $response = $this->getJson('/api/events');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }

    public function test_lists_events_that_belong_to_a_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Event::factory()->for($user)->count(2)->create();
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events?'.http_build_query([
                'user' => $user->id
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.user.id', $user->id)
            ->assertJsonPath('data.1.user.id', $user->id)
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }
    
    public function test_shows_a_single_event()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $event = Event::factory()->for($user)->create();

        $response = $this->getJson('/api/events/'.$event->id);
        
        $response->assertOk()
            ->assertJsonPath('data.id', $event->id)
            ->assertJsonPath('data.user.id', $user->id);
    }

    public function test_can_create_an_event()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        // $event = Event::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/events', Event::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id);

        $this->assertDatabaseHas('events', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_update_an_event()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $event = Event::factory()->for($user)->create();

        $this->actingAs($user);
        Sanctum::actingAs($user, ['event.update']);

        $response = $this->putJson('/api/events/'.$event->id, [
            'title' => 'updated title',
        ]);

        $response->assertOk();
            // ->assertJsonPath('data.title', 'updated title');
    }
    
    public function test_can_delete_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->for($user)->create();

        $this->actingAs($user);
        Sanctum::actingAs($user, ['event.delete']);

        $response = $this->deleteJson('/api/events/'.$event->id);

        $response->assertOk();

        $this->assertSoftDeleted($event);
    }
}
