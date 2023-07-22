<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Order::with(['orderTransaction.paymentMethod', 'orderTransaction.user', 'orderTracking.tracking', 'user', 'customer', 'printType'])->latest()->get();
        return response()->json(OrderResource::collection($data));
    }

    public function getByOrder(Request $request, $order)
    {
        $data = Order::where('order_number', $order)->with(['orderTransaction', 'orderTracking.tracking', 'user', 'customer', 'printType'])->get();
        // dd($data);
        // $data = Order::with(['orderTransaction', 'user', 'customer', 'printType'])->latest()->get();
        return response()->json(OrderResource::collection($data));
        // return response()->json($data);
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
            'order_number' => 'required',
            'user_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'print_type_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'name' => 'required',
            'description' => 'required',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::create([
            'order_number' => $request->order_number,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'print_type_id' => $request->print_type_id,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->total,
            'discount' => $request->discount,
            'subtotal' => $request->subtotal,
            'name' => $request->name,
            'description' => $request->description,
            'order_date' => $request->order_date,
        ]);

        return response()->json(['Order created successfully', new OrderResource($order)]);
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
            'order_number' => 'required',
            'user_id' => 'required|numeric',
            'customer_id' => 'required|numeric',
            'print_type_id' => 'required|numeric',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'name' => 'required',
            'description' => 'required',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::find($id);
        $order->update([
            'order_number' => $request->order_number,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'print_type_id' => $request->print_type_id,
            'qty' => $request->qty,
            'price' => $request->price,
            'total' => $request->total,
            'discount' => $request->discount,
            'subtotal' => $request->subtotal,
            'name' => $request->name,
            'description' => $request->description,
            'order_date' => $request->order_date,
        ]);

        return response()->json(['Order updated successfully', new OrderResource($order)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return response()->json(['Order deleted successfully']);
    }
}
