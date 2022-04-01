<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutExerciseFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'workout_id' => Workout::factory(),
            'exercise_id' => Exercise::factory(),
            'series' => $this->faker->numberBetween(1, 10),
            'repetitions' => $this->faker->numberBetween(1, 10),
        ];
    }
}
