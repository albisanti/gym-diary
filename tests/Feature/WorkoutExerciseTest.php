<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class WorkoutExerciseTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_exercise_for_workout()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $workout = Workout::factory()->create([
            'user_id' => $user->id,
        ]);
        $exercise = Exercise::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->put('/api/workout/exercises/',[
            'workout_id' => $workout->id,
            'exercise_id' => $exercise->id,
            'series' => 3,
            'repetitions' => 12,
            'weight' => 10
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_retrieve_workouts_exercises()
    {
        $workout = Workout::factory()->create();
        $response = $this->get('/api/workout/exercises/'.$workout->id);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercises' => []]);
    }

    public function test_update_exercise_for_workout()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $workout = Workout::factory()->create([
            'user_id' => $user->id,
        ]);
        $exercise = Exercise::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->patch('/api/workout/exercises',[
            'workout_id' => $workout->id,
            'exercise_id' => $exercise->id,
            'updatable' => [
                'series' => 5,
                'repetitions' => 5
            ]
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }


    public function test_delete_exercise_for_workout()
    {
        Sanctum::actingAs($user = User::factory()->create());
        $workout = Workout::factory()->create([
            'user_id' => $user->id,
        ]);
        $exercise = Exercise::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->delete('/api/workout/exercises/',[
            'workout_id' => $workout->id,
            'exercise_id' => $exercise->id,
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
