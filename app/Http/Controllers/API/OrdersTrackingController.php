<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTracking;
use App\Http\Resources\OrderTrackingResource;
use Validator;

class OrdersTrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderTracking = OrderTracking::with('order.customer')->latest()->get();
        return response()->json(OrderTrackingResource::collection($orderTracking));
    }

    public function indexByOrderId($id)
    {
        $orderTracking = OrderTracking::whereHas('order', function ($q) use ($id) {
            $q->where('order_number', $id);

        })->latest()->get();
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
            'order_id' => 'required',
            'tracking_id' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::create([
            'order_id' => $request->order_id,
            'tracking_id' => $request->tracking_id,
            'description' => $request->description,
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
            'order_id' => 'required',
            'tracking_id' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTracking = OrderTracking::find($id);
        $orderTracking->update([
            'order_id' => $request->order_id,
            'tracking_id' => $request->tracking_id,
            'description' => $request->description,
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
