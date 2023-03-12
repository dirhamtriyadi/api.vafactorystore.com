<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Material;
use App\Http\Resources\MaterialResource;

class MaterialController extends Controller
{
    public function index()
    {
        $data = Material::latest()->get();
        return response()->json([MaterialResource::collection($data)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:materials,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $material = Material::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json(['Material created successfully.', new MaterialResource($material)]);
    }

    public function show($id)
    {
        $material = Material::find($id);

        if (is_null($material)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([new MaterialResource($material)]);
    }

    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:materials,name,'. $material->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $material->name = $request->name;
        $material->description = $request->description;
        $material->save();

        return response()->json(['Material updated successfully.', new MaterialResource($material)]);
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json('Material deleted successfully');
    }
}
