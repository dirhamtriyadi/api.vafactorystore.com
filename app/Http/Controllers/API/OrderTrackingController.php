<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTracking;
use App\Http\Resources\OrderTrackingResource;
use Validator;

class OrderTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderTracking = OrderTracking::all();
        return response()->json(OrderTrackingResource::collection($orderTracking));
    }

    public function indexByOrderId($id)
    {
        $orderTracking = OrderTracking::where('order_id', $id)->get();
        return response()->json(OrderTrackingResource::collection($orderTracking));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'tracking_id' => 'required',
            'order_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::create([
            'tracking_id' => $request->tracking_id,
            'order_id' => $request->order_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'date' => $request->date,
        ]);

        return response()->json(['Order Tracking created successfully', new OrderTrackingResource($orderTracking)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tracking_id' => 'required',
            'order_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::find($id);
        $orderTracking->update([
            'tracking_id' => $request->tracking_id,
            'order_id' => $request->order_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'date' => $request->date,
        ]);

        return response()->json(['Order Tracking updated successfully', new OrderTrackingResource($orderTracking)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderTracking = OrderTracking::find($id);
        $orderTracking->delete();
        return response()->json(['Order Tracking deleted successfully']);
    }
}
