<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WorkoutExerciseTest extends TestCase
{

    public function test_create_exercise_for_workout()
    {
        $response = $this->put('/api/workout/exercises/',[
            'workout_id' => 1,
            'exercise_id' => 1,
            'series' => 3,
            'repetitions' => 12,
            'weight' => 10
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_retrieve_workouts_exercises()
    {
        $response = $this->get('/api/workout/exercises/1');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercises' => []]);
    }

    public function test_update_exercise_for_workout()
    {
        $response = $this->patch('/api/workout/exercises',[
            'workout_id' => 1,
            'exercise_id' => 1,
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
            'workout_id' => 1,
            'exercise_id' => 1
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
