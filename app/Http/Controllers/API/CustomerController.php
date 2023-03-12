<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Customer::latest()->get();
        return response()->json([CustomerResource::collection($data)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:customers,name',
            'phone' => 'required|numeric|unique:customers,phone',
            'email' => 'email|unique:customers,email'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return response()->json(['Customer created successfully.', new CustomerResource($customer)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return response()->json('Data not found', 404);
        }

        return response()->json([new CustomerResource($customer)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:customers,name,'. $customer->id,
            'phone' => 'required|numeric|unique:customers,phone,'. $customer->id,
            'email' => 'email|unique:customers,email,'. $customer->id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return response()->json(['Customer updated successfully.', new CustomerResource($customer)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json('Customer deleted successfully');
    }
}
