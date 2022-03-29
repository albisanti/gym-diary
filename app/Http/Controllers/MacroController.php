<?php

namespace App\Http\Controllers;

use App\Models\Macro;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MacroController extends Controller
{
    public function getMacro(\Illuminate\Http\Request $request): JsonResponse {
        $macro = Macro::find($request->id);
        if($macro) return response()->json(['status' => 'success', 'macro' => $macro]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovata nessuna macro']);
    }

    public function getAllMacros(){
        return response()->json(['status' => 'success','macro' => Macro::all()]);
    }

    public function createMacro(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'required|unique:macros|string|min:5|max:255',
            'description' => 'string|max:255'
        ]);
        $macro = new Macro;
        $macro->name = $request->name;
        $macro->description = $request->description;
        $macro->user_id = Auth::id();
        if($macro->save()) return response()->json(['status' => 'success','id' => $macro->id]);
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile inserire la macro']);
    }

    public function updateMacro(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'string|min:5|max:255',
            'description' => 'string|min:5|max:255'
        ]);
        $macro = Macro::find($request->id);
        if($macro){
            $macro->name = $request->name ?? $macro->name;
            $macro->description = $request->description ?? $macro->description;
            if($macro->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare la macro']);
        }
        return response()->json(['status' => 'error', 'report' => 'La macro ricercata non è stata trovata']);
    }

    public function deleteMacro(\Illuminate\Http\Request $request): JsonResponse {
        $macro = Macro::find($request->id);
        if($macro) {
            if ($macro->delete()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile cancellare la macro']);
    }
}
