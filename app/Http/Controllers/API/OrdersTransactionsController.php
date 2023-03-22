<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderTransaction;
use App\Http\Resources\OrderTransactionResource;
use Validator;

class OrdersTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = OrderTransaction::latest()->get();
        return response()->json(OrderTransactionResource::collection($data));
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
            'order_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTransaction = OrderTransaction::create([
            'order_id' => $request->order_id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return response()->json(['Orders Transaction created successfully', new OrderTransactionResource($orderTransaction)]);
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
            'order_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $orderTransaction = OrderTransaction::find($id);
        $orderTransaction->update([
            'order_id' => $request->order_id,
            'payment_method_id' => $request->payment_method_id,
            'amount' => $request->amount,
            'date' => $request->date,
        ]);

        return response()->json(['Orders Transaction updated successfully', new OrderTransactionResource($orderTransaction)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orderTransaction = OrderTransaction::find($id);
        $orderTransaction->delete();

        return response()->json(['Orders Transaction deleted successfully']);
    }
}
