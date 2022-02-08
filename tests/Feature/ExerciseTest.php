<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    public function test_exercise_creation(): int
    {
        $response = $this->put('/api/exercise',[
            'name' => 'Test of exercise',
            'description' => 'Testing exercise',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_exercise()
    {
        $response = $this->get('/api/exercise');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercise' => []]);
    }

    /**
     * @depends test_exercise_creation
     */
    public function test_get_exercise(int $id)
    {
        $response = $this->get('/api/exercise/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercise' => []]);
    }

    /**
     * @depends test_exercise_creation
     */
    public function test_exercise_update(int $id)
    {
        $response = $this->patch('/api/exercise/'.$id,[
            'name' => 'Test update exercise',
            'notes' => 'This is an updated note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    /**
     * @depends test_exercise_creation
     */
    public function test_exercise_delete(int $id)
    {
        $response = $this->delete('/api/exercise/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
