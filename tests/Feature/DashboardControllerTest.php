<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_correct_task_counts()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Task::factory()->count(5)->create(['user_id' => $user->id]);
        Task::factory()->count(2)->create(['user_id' => $user->id, 'status' => 'done']);
        Task::factory()->count(1)->create(['user_id' => $user->id])->delete(); 

        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);

        $response->assertViewHas('totalTasks', 5);
        $response->assertViewHas('completedTasks', 2);
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->count() === 5; 
        });
    }
}
