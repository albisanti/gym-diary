<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'workout_id' => Workout::factory()->create(),
            'exercise_id' => Exercise::factory()->create(),
            'workout_name' => $this->faker->title(),
            'exercise_name' => $this->faker->title(),
            'original_series' => $this->faker->numberBetween(1,4),
            'original_repetitions' => $this->faker->numberBetween(6,20),
            'original_weight' => $this->faker->numberBetween(10,40),
            'original_add_info' => $this->faker->sentence(),
            'original_notes' => $this->faker->sentence(25),
            'actual_series' => $this->faker->numberBetween(1,4),
            'actual_repetitions' => $this->faker->numberBetween(6,20),
            'actual_weight' => $this->faker->numberBetween(10,40),
            'feedback_rating' => $this->faker->randomElement(['less','ok','more']),
            'feedback_notes' => $this->faker->sentence(20),
        ];
    }
}
