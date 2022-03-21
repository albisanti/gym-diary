<?php

namespace App\Http\Controllers;


use App\Models\Workout;

class WorkoutExerciseController extends Controller
{
    public function AddNewExercise(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'workout_id' => 'required|integer',
            'exercise_id' => 'required|integer',
            'series' => 'integer|nullable',
            'repetitions' => 'integer|nullable',
            'weight' => 'numeric|nullable'
        ]);
        $workout = Workout::find($request->workout_id);
        if($workout){
            $workout->exercises()->attach($request->exercise_id,[
                'series' => $request->series,
                'repetitions' => $request->repetitions,
                'weight' => $request->weight,
                'additional_info' => $request->additional_info,
                'notes' => $request->notes
            ]);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error','report' => 'Non è trovato nessun workout']);
    }

    public function GetWorkoutsExercises(\Illuminate\Http\Request $request){
        $workout = Workout::find($request->id);
        if($workout){
            return response()->json(['status' => 'success','exercises' => $workout->exercises]);
        }
        return response()->json(['status' => 'error','report' => 'Non è trovato nessun esercizio']);
    }

    public function UpdateWorkoutsExercises(\Illuminate\Http\Request $request)
    {
        $this->validate($request,[
            'workout_id' => 'required|integer',
            'exercise_id' => 'integer|nullable',
            'updatable' => 'array'
        ]);
        $exercises = Workout::find($request->workout_id)->exercises();
        if($exercises){
            $fieldsToUpdate = [];
            foreach ($request->get('updatable') as $field => $val) {
                $fieldsToUpdate[$field] = $val;
            }
            $exercises->updateExistingPivot($request->exercise_id,$fieldsToUpdate);
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error','report' => 'Non è trovato nessun esercizio']);
    }

    public function DeleteWorkoutsExercises(\Illuminate\Http\Request $request)
    {
        $this->validate($request,[
            'workout_id' => 'required|integer',
            'exercise_id' => 'integer|nullable'
        ]);
        Workout::find($request->workout_id)->exercises()->detach($request->exercise_id);
        return response()->json(['status' => 'success']);
    }
}
