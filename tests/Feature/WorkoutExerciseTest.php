<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutExerciseTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_exercise_for_workout()
    {
        $response = $this->put('/api/workout/exercises/',[
            'workout_id' => Workout::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
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
        $response = $this->patch('/api/workout/exercises',[
            'workout_id' => Workout::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
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
        $response = $this->delete('/api/workout/exercises/',[
            'workout_id' => Workout::factory()->create()->id,
            'exercise_id' => Exercise::factory()->create()->id,
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
