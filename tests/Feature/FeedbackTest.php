<?php

namespace Tests\Feature;

use App\Models\Exercise;
use App\Models\Feedback;
use App\Models\Workout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public function test_create_feedback(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $exercise = Exercise::factory()->create([
            'user_id' => $user->id
        ]);
        $workout = Workout::factory()->hasAttached($exercise,[
            'series' => $this->faker->numberBetween(1,4),
            'repetitions' => $this->faker->numberBetween(6,20),
        ])->create([
            'user_id' => $user->id
        ]);
        $response = $this->put('/api/feedback',[
            'workout_id' => $workout->id,
            'exercise_id' => $exercise->id,
            'feedback_rating' => 'more',
            'feedback_notes' => ''
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_get_all_feedback(): void
    {
        $feedback = Feedback::factory()->create();
        $response = $this->get('/api/feedback/'.$feedback->id);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success', 'feedback' => []]);
    }

    public function test_update_feedback(): void
    {
        $feedback = Feedback::factory()->create();
        $response = $this->patch('/api/feedback/'.$feedback->id,[
           'feedback_rating' => 'ok',
           'feedback_notes' => 'Updated notes'
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    public function test_delete_feedback(): void
    {
        $feedback = Feedback::factory()->create();
        $response = $this->delete('/api/feedback/'.$feedback->id);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
