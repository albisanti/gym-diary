<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function getCategory(\Illuminate\Http\Request $request): JsonResponse {
        $category = Category::find($request->id);
        if($category) return response()->json(['status' => 'success', 'category' => $category]);
        return response()->json(['status' => 'error', 'report' => 'Non è stata trovata nessuna categoria']);
    }

    public function getAllCategories(){
        return response()->json(['status' => 'success','category' => Category::all()]);
    }

    public function createCategory(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'required|unique:categories|string|min:5|max:255',
            'description' => 'string|max:255'
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->user_id = Auth::id();
        if($category->save()) return response()->json(['status' => 'success','id' => $category->id]);
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile inserire la categoria']);
    }

    public function updateCategory(\Illuminate\Http\Request $request): JsonResponse {
        $this->validate($request,[
            'name' => 'string|min:5|max:255',
            'description' => 'string|min:5|max:255'
        ]);
        $category = Category::find($request->id);
        if($category){
            $category->name = $request->name ?? $category->name;
            $category->description = $request->description ?? $category->description;
            if($category->save()) return response()->json(['status' => 'success']);
            return response()->json(['status' => 'error', 'report' => 'Non è stato possibile modificare la categoria']);
        }
        return response()->json(['status' => 'error', 'report' => 'La categoria ricercata non è stata trovata']);
    }

    public function deleteCategory(\Illuminate\Http\Request $request): JsonResponse {
        $category = Category::find($request->id);
        if($category) {
            if ($category->delete()) return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'report' => 'Non è stato possibile cancellare la categoria']);
    }
}
