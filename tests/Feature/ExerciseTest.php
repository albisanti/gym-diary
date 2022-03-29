<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;
    public function test_exercise_creation(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->put('/api/exercise',[
            'name' => 'Test of exercise',
            'description' => 'Testing exercise',
            'notes' => 'This is a note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_exercise(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->get('/api/exercise');

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercise' => []]);
    }

    public function test_get_exercise(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        $response = $this->get('/api/exercise/'.$exercise->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success','exercise' => []]);
    }

    public function test_exercise_update(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        $response = $this->patch('/api/exercise/'.$exercise->id,[
            'name' => 'Test update exercise',
            'notes' => 'This is an updated note'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_exercise_delete(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $exercise = Exercise::factory()->create(['user_id' => $user->id]);
        $response = $this->delete('/api/exercise/'.$exercise->id);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
