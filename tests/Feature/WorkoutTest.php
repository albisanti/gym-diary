<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Nette\Utils\DateTime;
use Tests\TestCase;

class WorkoutTest extends TestCase
{
    public function test_workout_creation(): int
    {
        $response = $this->put('/api/workout',[
            'name' => 'Test of workout',
            'description' => 'Testing workout',
            'type' => 'TestType',
            'notes' => 'This is a note',
            'start_at' => date('Y-m-d'),
            'end_at' => null,
            'created_by' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_workout()
    {
        $response = $this->get('/api/workout');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','workout' => []]);
    }

    /**
     * @depends test_workout_creation
     */
    public function test_get_workout(int $id)
    {
        $response = $this->get('/api/workout/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','workout' => []]);
    }

    /**
     * @depends test_workout_creation
     */
    public function test_workout_update(int $id)
    {
        $response = $this->patch('/api/workout/'.$id,[
            'name' => 'Test update workout',
            'notes' => 'This is an updated note',
            'end_at' => Carbon::now()->addDays(31)
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    /**
     * @depends test_workout_creation
     */
    public function test_workout_delete(int $id)
    {
        $response = $this->delete('/api/workout/'.$id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
