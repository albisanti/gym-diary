<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Nette\Utils\DateTime;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_workout_creation(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $userAssigner = User::factory()->create();
        $response = $this->put('/api/workout',[
            'name' => 'Test of workout',
            'description' => 'Testing workout',
            'type' => 'TestType',
            'notes' => 'This is a note',
            'start_at' => date('Y-m-d'),
            'end_at' => null
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_workout(): void
    {
        $response = $this->get('/api/workout');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','workout' => []]);
    }

    public function test_get_workout(): void
    {
        $user = User::factory()->create();
        $userAssigner = User::factory()->create();
        $workout = Workout::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->get('/api/workout/'.$workout->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','workout' => []]);
    }

    public function test_workout_update(): void
    {
        $user = User::factory()->create();
        $userAssigner = User::factory()->create();
        $workout = Workout::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->patch('/api/workout/'.$workout->id,[
            'name' => 'Test update workout',
            'notes' => 'This is an updated note',
            'end_at' => Carbon::now()->addDays(31)
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_workout_delete(): void
    {
        $user = User::factory()->create();
        $userAssigner = User::factory()->create();
        $workout = Workout::factory()->create([
            'user_id' => $user->id
        ]);
        $response = $this->delete('/api/workout/'.$workout->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
