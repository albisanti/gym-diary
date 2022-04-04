<?php

namespace App\Policies;

use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkoutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Workout $workout)
    {
        return $user->id === (int)$workout->user_id || $user->id === (int)$workout->assigned_to;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Workout $workout)
    {
        return $user->id === (int)$workout->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Workout $workout)
    {
        return $user->id === (int)$workout->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Workout $workout)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Workout $workout)
    {
        //
    }

    /**
     * Determine whether the user can add an exercise to a workout.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addExercise(User $user, Workout $workout, Exercise $exercise)
    {
        return $user->id === (int)$workout->user_id;
    }
}
