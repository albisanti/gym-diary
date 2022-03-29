<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function getEquipment(\Illuminate\Http\Request $request): JsonResponse {
        $equipment = Equipment::find($request->id);
        if($equipment) return response()->json(['status' => 'success', 'equipment' => $equipment]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovata nessun attrezzo']);
    }

    public function getAllEquipments(){
        return response()->json(['status' => 'success','equipment' => Equipment::all()]);
    }

    public function createEquipment(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'required|unique:equipments|string|min:5|max:255',
            'description' => 'string|max:255',
            'notes' => 'string|max:255'
        ]);
        $equipment = new Equipment;
        $equipment->name = $request->name;
        $equipment->description = $request->description;
        $equipment->notes = $request->notes;
        $equipment->user_id = Auth::id();
        if($equipment->save()) return response()->json(['status' => 'success','id' => $equipment->id]);
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile inserire l\'attrezzo']);
    }

    public function updateEquipment(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'string|min:5|max:255',
            'description' => 'string|min:5|max:255'
        ]);
        $equipment = Equipment::find($request->id);
        if($equipment){
            $equipment->name = $request->name ?? $equipment->name;
            $equipment->description = $request->description ?? $equipment->description;
            if($equipment->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare l\'attrezzo']);
        }
        return response()->json(['status' => 'error', 'report' => 'L\'attrezzo ricercata non è stata trovata']);
    }

    public function deleteEquipment(\Illuminate\Http\Request $request): JsonResponse {
        $equipment = Equipment::find($request->id);
        if($equipment) {
            if ($equipment->delete()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile cancellare l\'attrezzo']);
    }
}
