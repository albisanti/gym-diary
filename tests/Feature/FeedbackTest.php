<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FeedbackTest extends TestCase
{

    public function test_create_feedback()
    {
        $response = $this->put('/api/feedback',[
            'workout_id' => 1,
            'exercise_id' => 2,
            'feedback_rating' => 'more',
            'feedback_notes' => ''
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $findId = json_decode($response->getContent());
        return $findId->id;
    }

    public function test_get_all_feedback()
    {
        $response = $this->get('/api/feedback/1');
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success', 'feedback' => []]);
    }

    /**
     * @depends test_create_feedback
     */
    public function test_update_feedback(int $idFeedback)
    {
        $response = $this->patch('/api/feedback/'.$idFeedback,[
           'feedback_rating' => 'ok',
           'feedback_notes' => 'Updated notes'
        ]);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }

    /**
     * @depends test_create_feedback
     */
    public function test_delete_feedback(int $idFeedback)
    {
        $response = $this->delete('/api/feedback/'.$idFeedback);
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
    }
}
