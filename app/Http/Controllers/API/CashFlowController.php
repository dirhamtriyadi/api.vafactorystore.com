<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashFlowResource;
use Validator;
use DB;
use App\Models\CashFlow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');

        $data = CashFlow::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('transaction_date', 'DESC');

        if ($request->start_date && $request->end_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $end_date = Carbon::createFromFormat('Y-m-d', $request->end_date);
        }

        $ls = $data->whereBetween(DB::raw('transaction_date'), [$start_date, $end_date])->get();

        return response()->json(CashFlowResource::collection(($ls)));
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
            'transaction_date' => 'required|date',
            'user_id' => 'required|numeric',
            'cash_flow_type' => 'required',
            'amount' => 'required|numeric',
            'payment_methods_id' => 'required|numeric',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $cashFlow = CashFlow::create([
            'transaction_date' => $request->transaction_date,
            'user_id' => $request->user_id,
            'cash_flow_type' => $request->cash_flow_type,
            'amount' => $request->amount,
            'payment_methods_id' => $request->payment_methods_id,
            'description' => $request->description
        ]);

        return response()->json(['Cash flow created successfully.', new CashFlowResource($cashFlow)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cashFlow = CashFlow::find($id);
        if (is_null($cashFlow)) {
            return response()->json('Data not found', 404);
        }
        return response()->json(new CashFlowResource($cashFlow));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashFlow $cashFlow)
    {
        $cashFlow->delete();

        return response()->json('Cash flow deleted successfully');
    }
}
