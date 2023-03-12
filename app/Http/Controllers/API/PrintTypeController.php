<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\PrintType;
use App\Http\Resources\PrintTypeResource;

class PrintTypeController extends Controller
{
    public function index()
    {
        $data = PrintType::latest()->get();
        return response()->json([PrintTypeResource::collection($data)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:print_types,name',
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $printType = PrintType::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return response()->json(['Print type created successfully.', new PrintTypeResource($printType)]);
    }

    public function show($id)
    {
        $printType = PrintType::find($id);

        if (is_null($printType)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([new PrintTypeResource($printType)]);
    }

    public function update(Request $request, PrintType $printType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:print_types,name,'. $printType->id,
            'price' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $printType->name = $request->name;
        $printType->price = $request->price;
        $printType->description = $request->description;
        $printType->save();

        return response()->json(['Print type updated successfully.', new PrintTypeResource($printType)]);
    }

    public function destroy(PrintType $printType)
    {
        $printType->delete();

        return response()->json('Print type deleted successfully');
    }
}
