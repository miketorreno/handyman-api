<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class PostControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_posts()
    {
        $user = User::factory()->create();
        Post::factory(3)->for($user)->create();

        $response = $this->getJson('/api/blogposts');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }

    public function test_lists_posts_with_pagination()
    {
        Post::factory(20)->create();

        $response = $this->getJson('/api/blogposts');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }
    
    public function test_shows_a_single_post()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $response = $this->getJson('/api/blogposts/'.$post->id);
        // dd($response);
        
        $response->assertOk();
            // ->assertJsonPath('data.id', $post->id)
            // ->assertJsonPath('data.user.id', $user->id);
    }

    public function test_can_create_a_post()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/blogposts', Post::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id);

        $this->assertDatabaseHas('posts', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_update_a_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/blogposts/'.$post->id, [
            'title' => 'updated title',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.title', 'updated title');
    }
    
    public function test_can_delete_a_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/blogposts/'.$post->id);

        $response->assertOk();

        $this->assertSoftDeleted($post);
    }
}
