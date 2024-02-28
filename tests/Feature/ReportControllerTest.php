<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

class ReportControllerTest extends TestCase
{
    use LazilyRefreshDatabase, WithFaker;
    
    public function test_lists_reports()
    {
        $user = User::factory()->create();
        Report::factory(3)->for($user)->create();
        Report::factory(3)->for($user)->forHandyman()->create();

        $response = $this->getJson('/api/reports');

        $response->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }

    public function test_lists_reports_with_pagination()
    {
        Report::factory(20)->create();

        $response = $this->getJson('/api/reports');

        $response->assertOk()
            ->assertJsonStructure(['data', 'meta', 'links'])
            ->assertJsonCount(15, 'data')
            ->assertJsonStructure(['data' => ['*' => ['id', 'user_id']]]);
    }
    
    public function test_shows_a_single_report()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $report = Report::factory()->for($user)->create();

        $response = $this->getJson('/api/reports/'.$report->id);
        
        $response->assertOk()
            ->assertJsonPath('data.id', $report->id)
            ->assertJsonPath('data.user.id', $user->id);
    }

    public function test_can_create_a_report()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        // $report = Report::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/reports', Report::factory()->raw([
            'user_id' => $user->id,
        ]));

        $response->assertCreated()
            ->assertJsonPath('data.user.id', $user->id);

        $this->assertDatabaseHas('reports', [
            'id' => $response->json('data.id')
        ]);
    }

    public function test_can_update_a_report()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $report = Report::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->putJson('/api/reports/'.$report->id, [
            'reason' => 'updated reason',
        ]);

        $response->assertOk()
            ->assertJsonPath('data.reason', 'updated reason');
    }
    
    public function test_can_delete_a_report()
    {
        $user = User::factory()->create();
        $report = Report::factory()->for($user)->create();

        $this->actingAs($user);

        $response = $this->deleteJson('/api/reports/'.$report->id);

        $response->assertOk();

        $this->assertSoftDeleted($report);
    }
}
