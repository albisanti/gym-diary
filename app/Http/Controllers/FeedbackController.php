<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Workout;

class FeedbackController extends Controller
{
    public function AddNewFeedback(\Illuminate\Http\Request $request){
        $this->validate($request,[
            'workout_id' => 'required|integer',
            'exercise_id' => 'required|integer'
        ]);

        $workout = Workout::find($request->workout_id);
        if($workout){
            $exercise = $workout->exercises()->where('exercises.id','=',$request->exercise_id)->first();
            if($exercise){
                $feedback = new Feedback;
                $feedback->workout_id = $request->workout_id;
                $feedback->exercise_id = $request->exercise_id;
                $feedback->workout_name = $workout->name;
                $feedback->exercise_name = $exercise->name;
                $feedback->original_series = $exercise->pivot->series;
                $feedback->original_repetitions = $exercise->pivot->repetitions;
                $feedback->original_weight = $exercise->pivot->weight;
                $feedback->original_add_info = $exercise->pivot->add_info;
                $feedback->original_notes = $exercise->pivot->notes;
                $feedback->actual_series = $request->actual_series;
                $feedback->actual_repetitions = $request->actual_repetitions;
                $feedback->actual_weight = $request->actual_weight;
                $feedback->feedback_rating = $request->feedback_rating;
                $feedback->feedback_notes = $request->feedback_notes;
                if($feedback->save()){
                    return response()->json(['status' => 'success','id' => $feedback->id]);
                }
                return response()->json(['status' => 'error','report' => 'Non è stato possibile inserire il feedback. Riprova più tardi']);
            }
            return response()->json(['status' => 'error','report' => 'Non è stato trovato nessun esercizio']);
        }
        return response()->json(['status' => 'error','report' => 'Non è stato trovato nessun workout']);
    }

    public function GetFeedbackFromWorkoutId(\Illuminate\Http\Request $request){
        $workout = Workout::find($request->workoutId);
        if($workout){
            $feedback = $workout->feedback()->select('created_at')->groupBy('created_at')->get();
            if($feedback){
                return response()->json(['status' => 'success','feedback' => $feedback]);
            }
            return response()->json(['status' => 'error', 'report' => 'Nessun feedback per il workout selezionato']);
        }
        return response()->json(['status' => 'error', 'report' => 'Nessun workout trovato']);
    }

    public function UpdateFeedback(\Illuminate\Http\Request $request){
        $feedback = Feedback::find($request->id);
        if($feedback) {
            $feedback->original_series = $request->series ?? $feedback->original_series;
            $feedback->original_repetitions = $request->repetitions ?? $feedback->original_repetitions;
            $feedback->original_weight = $request->weight ?? $feedback->original_weight;
            $feedback->original_add_info = $request->add_info ?? $feedback->original_add_info;
            $feedback->original_notes = $request->notes ?? $feedback->original_notes;
            $feedback->actual_series = $request->actual_series ?? $feedback->actual_series;
            $feedback->actual_repetitions = $request->actual_repetitions ?? $feedback->actual_repetitions;
            $feedback->actual_weight = $request->actual_weight ?? $feedback->actual_weight;
            $feedback->feedback_rating = $request->feedback_rating ?? $feedback->feedback_rating;
            $feedback->feedback_notes = $request->feedback_notes ?? $feedback->feedback_notes;
            if($feedback->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare il feedback']);
        }
        return response()->json(['status' => 'error', 'report' => 'Nessun feedback trovato']);
    }

    public function RemoveFeedback(\Illuminate\Http\Request $request){
        $feedback = Feedback::find($request->id);
        if($feedback) {
            $feedback->delete();
            if($feedback->save()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Nessun feedback trovato']);
    }

}
