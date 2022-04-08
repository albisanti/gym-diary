<?php

namespace Database\Seeders;

use App\Models\UserCustomer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'id' => 1,
            'name' => 'Alberto',
            'email' => 'test@test.com',
            'password' => \Hash::make('test123'),
            'email_verified_at' => now(),
        ]);
        \DB::table('workouts')->insert([
            'name' => 'Test day1',
            'description' => 'testing a workout',
            'created_by' => 1
        ]);
        \DB::table('exercises')->insert([
            'name' => 'Curl',
            'description' => 'Big muscles',
            'notes' => 'Do this for big muscles!'
        ]);
        \DB::table('exercises')->insert([
            'name' => 'Leg',
            'description' => 'Big muscles',
            'notes' => 'Do this for big leg muscles!'
        ]);
        \DB::table('workout_exercise')->insert([
            'workout_id' => 1,
            'exercise_id' => 2,
            'series' => 5,
            'repetitions' => 5
        ]);
        UserCustomer::factory()->count(10)->create([
            'user_id' => 1
        ]);
    }
}
