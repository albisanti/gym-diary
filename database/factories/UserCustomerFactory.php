<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserCustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'customer_id' => User::factory(),
            'hash' => Hash::make('test'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'accepted','refused']),
        ];
    }
}
