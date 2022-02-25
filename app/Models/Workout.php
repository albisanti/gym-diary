<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    public function exercises(){
        return $this->belongsToMany(Exercise::class,'workout_exercise')
            ->using(WorkoutExercise::class)
            ->withPivot('series','repetitions','weight','additional_info','notes');
    }

    public function feedback(){
        return $this->hasMany(Feedback::class);
    }
}
