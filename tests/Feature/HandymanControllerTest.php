<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Quote;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\Handyman;
use App\Models\SubscriptionType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class HandymanControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_handymen()
    {
        Handyman::factory(3)->create();

        $response = $this->getJson('/api/handymen');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
        // $this->assertNotNull($response->json('data')[0]['id']);
    }

    public function test_lists_handymen_with_pagination()
    {
        Handyman::factory(20)->create();

        $response = $this->getJson('/api/handymen');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }

    public function test_only_lists_handymen_that_are_approved()
    {
        Handyman::factory(3)->create();
        Handyman::factory()->create(['approval_status' => Handyman::APPROVAL_PENDING]);
        Handyman::factory()->create(['approval_status' => Handyman::APPROVAL_REJECTED]);

        $response = $this->getJson('/api/handymen');

        $response->assertOk()
            ->assertJsonCount(3, 'data');
    }
    
    public function test_filters_handymen_by_categories()
    {
        $categories = Category::factory(2)->create();
        $handyman = Handyman::factory()->hasAttached($categories)->create();
        Handyman::factory()->hasAttached($categories->first())->create();
        Handyman::factory()->create();

        $response = $this->getJson('/api/handymen?'.http_build_query([
                'categories' => $categories->pluck('id')->toArray()
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.id', $handyman->id);
    }
    
    public function test_filters_handymen_by_services()
    {
        $services = Service::factory(2)->create();
        $handyman = Handyman::factory()->hasAttached($services)->create();
        Handyman::factory()->hasAttached($services->first())->create();
        Handyman::factory()->create();

        $response = $this->getJson('/api/handymen?'.http_build_query([
                'services' => $services->pluck('id')->toArray()
            ])
        );

        $response->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.id', $handyman->id);
    }
    
    public function test_filters_handymen_by_location()
    {
        User::factory(2)->create();
        $user1 = User::factory()->create(['location' => 'addis']);
        $user2 = User::factory()->create(['location' => 'adama']);
        $handyman1 = Handyman::factory()->for($user1)->create();
        $handyman2 = Handyman::factory()->for($user2)->create();

        $response = $this->getJson('/api/handymen?'.http_build_query([
                'location' => 'adama'
            ])
        );

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $handyman2->id);
    }
    
    // public function test_filters_handymen_by_language()
    // {
    //     $handyman1 = Handyman::factory()->create();
    //     $handyman2 = Handyman::factory()->create();

    //     $response = $this->getJson('/api/handymen?'.http_build_query([
    //             'language' => 'english'
    //         ])
    //     );

    //     $response->assertOk()
    //         ->assertJsonCount(2, 'data');
    //         // ->assertJsonPath('data.0.id', $handyman2->id);
    // }

    public function test_includes_subscription_type_categories_services_reviews_quotes_and_the_user()
    {
        $user = User::factory()->create();
        $subscriptionType = SubscriptionType::factory()->create();
        $handyman = Handyman::factory()->for($user)->for($subscriptionType)->hasCategories(1)->hasServices(1)->create();
        $handyman->reviews()->create(['user_id' => $user->id]);
        Quote::factory()->for($handyman)->create();

        $response = $this->getJson('/api/handymen');

        $response->assertOk()
            ->assertJsonCount(1, 'data.0.reviews')
            ->assertJsonCount(1, 'data.0.quotes')
            ->assertJsonCount(1, 'data.0.services')
            ->assertJsonCount(1, 'data.0.categories')
            ->assertJsonPath('data.0.subscription_type.id', $subscriptionType->id)
            ->assertJsonPath('data.0.user.id', $user->id);
    }

    // public function test_returns_number_of_reviews()
    // {
    //     $handyman = Handyman::factory()->create();
    //     Review::factory(4)->for($handyman)->create();

    //     $response = $this->getJson('/api/handyman');

    //     $response->assertOk()
    //         ->assertJsonPath('data.0.reviews_count', 4);
    // }
}
