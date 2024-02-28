<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Review;
use App\Models\Handyman;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class ReviewControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;

    public function test_lists_reviews_that_belong_to_a_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();
        Review::factory()->for($user)->for($handyman)->count(2)->create();
        Review::factory()->count(3)->create();

        $response = $this->getJson('/api/reviews?'.http_build_query([
                'user' => $user->id
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.user.id', $user->id)
            ->assertJsonPath('data.1.user.id', $user->id)
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['id', 'rating', 'review']]]);
    }

    public function test_lists_reviews_that_belong_to_a_handyman()
    {
        $handyman = Handyman::factory()->create();
        Review::factory()->for($handyman)->count(2)->create();
        Review::factory()->count(3)->create();

        $response = $this->getJson('/api/reviews?'.http_build_query([
                'handyman' => $handyman->id
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.handyman.id', $handyman->id)
            ->assertJsonPath('data.1.handyman.id', $handyman->id)
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['id', 'rating', 'review']]]);
    }

    public function test_lists_all_reviews_if_neither_user_nor_handyman_provided()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();
        Review::factory()->for($user)->count(2)->create();
        Review::factory()->for($handyman)->count(2)->create();
        Review::factory()->count(3)->create();

        $response = $this->getJson('/api/reviews');

        $response->assertOk()
            ->assertJsonCount(7, 'data')
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['id', 'rating', 'review']]]);
    }

    public function test_includes_handyman_and_user()
    {
        Review::factory()->create();

        $response = $this->getJson('/api/reviews');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonStructure(['data' => ['*' => ['user', 'handyman', 'id', 'rating', 'review']]]);
    }
    
    public function test_shows_a_single_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $response = $this->getJson('/api/reviews/'.$review->id);

        $response->assertOk()
            ->assertJsonPath('data.user_id', $user->id);
    }

    public function test_can_create_a_review()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reviews', Review::factory()->raw([
            'handyman_id' => $handyman->id,
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user_id', $user->id)
            ->assertJsonPath('data.handyman_id', $handyman->id);
        $this->assertDatabaseHas('reviews', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_not_create_a_review_on_non_existing_handyman()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reviews', Review::factory()->raw([
            'handyman_id' => 1234,
        ]));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['handyman' => 'Handyman does not exist']);
    }

    public function test_can_not_create_a_review_without_either_rating_or_review_field()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reviews', [
            'user_id' => $user->id,
            'handyman_id' => $handyman->id,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['review' => 'Write a review and/or rate the handyman']);
    }

    public function test_can_create_a_review_with_only_rating_field()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reviews', [
            'handyman_id' => $handyman->id,
            'user_id' => $user->id,
            'rating' => rand(1, 5),
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.user_id', $user->id)
            ->assertJsonPath('data.handyman_id', $handyman->id);
        $this->assertDatabaseHas('reviews', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_create_a_review_with_only_review_field()
    {
        $user = User::factory()->create();
        $handyman = Handyman::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reviews', [
            'handyman_id' => $handyman->id,
            'user_id' => $user->id,
            'review' => fake()->paragraph(),
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.user_id', $user->id)
            ->assertJsonPath('data.handyman_id', $handyman->id);
        $this->assertDatabaseHas('reviews', [
            'id' => $response->json('data.id')
        ]);
    }
    
    public function test_can_update_a_review()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reviews/'.$review->id, [
            'rating' => 4,
            'review' => 'Updated Review',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.rating', 4)
            ->assertJsonPath('data.review', 'Updated Review');
    }
    
    public function test_can_update_a_review_with_only_rating_field()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reviews/'.$review->id, [
            'rating' => 4,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.rating', 4);
    }
    
    public function test_can_update_a_review_with_only_review_field()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reviews/'.$review->id, [
            'review' => 'Updated Review',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.review', 'Updated Review');
    }
    
    public function test_can_not_update_a_review_without_either_rating_or_review_field()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reviews/'.$review->id, []);

        $response->assertOk()
            ->assertJsonPath('data.id', $review->id)
            ->assertJsonPath('data.rating', $review->rating)
            ->assertJsonPath('data.review', $review->review);
    }

    public function test_can_not_update_a_review_that_does_not_belong_to_user()
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $review = Review::factory()->for($anotherUser)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reviews/'.$review->id, [
            'review' => 'Amazing Review'
        ]);

        $response->assertForbidden();
    }

    public function test_does_not_allow_updating_if_scope_is_not_provided()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        $this->actingAs($user, []);

        $response = $this->putJson('/api/reviews/'.$review->id);

        $response->assertForbidden();
    }
    
    public function test_can_delete_a_review()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/reviews/'.$review->id);

        $response->assertOk();

        $this->assertSoftDeleted($review);
    }
    
    public function test_can_not_delete_a_review_that_does_not_belong_to_user()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $review = Review::factory()->for($anotherUser)->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/reviews/'.$review->id);

        $response->assertStatus(403);
    }

    public function test_does_not_allow_deleting_if_scope_is_not_provided()
    {
        $user = User::factory()->create();
        $review = Review::factory()->create();

        $this->actingAs($user, []);

        $response = $this->deleteJson('/api/reviews/'.$review->id);

        $response->assertForbidden();
    }
}
