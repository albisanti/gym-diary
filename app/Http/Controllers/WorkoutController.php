<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class WorkoutController extends Controller
{
    public function getWorkout(\Illuminate\Http\Request $request): JsonResponse {
        $workout = Workout::find($request->id);
        if($workout) return response()->json(['status' => 'success', 'workout' => $workout]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovato alcun workout']);
    }

    public function getAllWorkouts(){
        return response()->json(['status' => 'success','workout' => Workout::all()]);
    }

    public function createWorkout(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'required|unique:equipments|string|min:5|max:255',
            'description' => 'string|max:255',
            'type' => 'string|max:255',
            'start_at' => 'date',
            'end_at' => 'nullable|date',
            'notes' => 'string|max:255',
        ]);
        if(Gate::allows('assign-workout', $request->assigned_to)) {
            $workout = new Workout;
            $workout->name = $request->name;
            $workout->description = $request->description;
            $workout->type = $request->type;
            $workout->assigned_to = $request->assigned_to;
            $workout->start_at = $request->start_at;
            $workout->end_at = $request->end_at;
            $workout->user_id = Auth::id();
            $workout->notes = $request->notes;
            if($workout->save()) return response()->json(['status' => 'success','id' => $workout->id]);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile inserire il workout']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non hai i permessi per inserire questo workout'],403);
    }

    public function updateWorkout(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'string|min:5|max:255',
            'description' => 'string|min:5|max:255'
        ]);
        $workout = Workout::find($request->id);
        if($workout){
            $workout->name = $request->name ?? $workout->name;
            $workout->description = $request->description ?? $workout->description;
            if($workout->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare l\'attrezzo']);
        }
        return response()->json(['status' => 'error', 'report' => 'Il workout ricercata non è stata trovata']);
    }

    public function deleteWorkout(\Illuminate\Http\Request $request): JsonResponse {
        $workout = Workout::find($request->id);
        if($workout) {
            if ($workout->delete()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile cancellare il workout']);
    }
}
