<?php

namespace Database\Seeders;

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
            'name' => 'Alberto',
            'email' => 'test@test.com',
            'password' => \Hash::make('test123')
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
    }
}
