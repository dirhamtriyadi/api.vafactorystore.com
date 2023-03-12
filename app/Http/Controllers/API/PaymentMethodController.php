<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\PaymentMethod;
use App\Http\Resources\PaymentMethodResource;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $data = PaymentMethod::latest()->get();
        return response()->json([PaymentMethodResource::collection($data)]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:payment_methods,name'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $PaymentMethod = PaymentMethod::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json(['Payment method created successfully.', new PaymentMethodResource($PaymentMethod)]);
    }

    public function show($id)
    {
        $PaymentMethod = PaymentMethod::find($id);

        if (is_null($PaymentMethod)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([new PaymentMethodResource($PaymentMethod)]);
    }

    public function update(Request $request, PaymentMethod $PaymentMethod)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:payment_methods,name,'. $PaymentMethod->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $PaymentMethod->name = $request->name;
        $PaymentMethod->description = $request->description;
        $PaymentMethod->save();

        return response()->json(['Payment method updated successfully.', new PaymentMethodResource($PaymentMethod)]);
    }

    public function destroy(PaymentMethod $PaymentMethod)
    {
        $PaymentMethod->delete();

        return response()->json('Payment method deleted successfully');
    }
}
