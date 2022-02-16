<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function getExercise(\Illuminate\Http\Request $request): JsonResponse {
        $exercise = Exercise::find($request->id);
        if($exercise) return response()->json(['status' => 'success', 'exercise' => $exercise]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovata nessun attrezzo']);
    }

    public function getAllExercises(){
        return response()->json(['status' => 'success','exercise' => Exercise::all()]);
    }

    public function createExercise(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'required|unique:equipments|string|min:5|max:255',
            'description' => 'string|max:255',
            'notes' => 'string|max:255'
        ]);
        $exercise = new Exercise;
        $exercise->name = $request->name;
        $exercise->description = $request->description;
        $exercise->notes = $request->notes;
        if($exercise->save()) return response()->json(['status' => 'success','id' => $exercise->id]);
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile inserire l\'attrezzo']);
    }

    public function updateExercise(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'string|min:5|max:255',
            'description' => 'string|min:5|max:255'
        ]);
        $exercise = Exercise::find($request->id);
        if($exercise){
            $exercise->name = $request->name ?? $exercise->name;
            $exercise->description = $request->description ?? $exercise->description;
            if($exercise->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare l\'attrezzo']);
        }
        return response()->json(['status' => 'error', 'report' => 'L\'attrezzo ricercata non è stata trovata']);
    }

    public function deleteExercise(\Illuminate\Http\Request $request): JsonResponse {
        $exercise = Exercise::find($request->id);
        if($exercise) {
            if ($exercise->delete()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile cancellare l\'attrezzo']);
    }
}
