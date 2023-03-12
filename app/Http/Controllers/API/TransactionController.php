<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Validator;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Transaction::with(['transactionDetails'])->get();
        return response()->json(TransactionResource::collection($data));
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
            'date' => 'required|date',
            'transaction_number' => 'required|unique:transactions,transaction_number',
            'users_id' => 'required|numeric',
            'customers_id' => 'required|numeric',
            'items' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaction = Transaction::create([
            'date' => $request->date,
            'transaction_number' => $request->transaction_number,
            'users_id' => $request->users_id,
            'customers_id' => $request->customers_id
        ]);

        if ($transaction) {
            foreach ($request->items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'description' => $item['description']
                ]);
            }

            /* if ($request->payment) {
                Payment::create([
                    'date' => $item->price,
                    'transactions_id' => $transaction->id,
                    'termin' => $item->products_id,
                    'amount' => $item->qty,
                    'description' => $item->description
                ]);
            } */
        }

        return response()->json(['Transaction created successfully.', new TransactionResource($transaction)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if (is_null($transaction)) {
            return response()->json('Data not found', 404);
        }

        return response()->json(new TransactionResource($transaction));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'transaction_number' => 'required|unique:transactions,transaction_number,'. $transaction->id,
            // 'users_id' => 'required|numeric',
            'customers_id' => 'required|numeric',
            'items' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $transaction->date = $request->date;
        $transaction->transaction_number = $request->transaction_number;
        $transaction->customers_id = $request->customers_id;
        $updatedTransaction = $transaction->save();

        if ($updatedTransaction) {
            foreach ($request->items as $item) {
                TransactionDetail::upsert(
                    [[
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'description' => $item['description']
                    ]],
                    ['transaction_id', 'product_id'],
                    ['qty', 'price', 'subtotal', 'description']
                );
            }

            /* if ($request->payment) {
                Payment::create([
                    'date' => $item->price,
                    'transactions_id' => $transaction->id,
                    'termin' => $item->products_id,
                    'amount' => $item->qty,
                    'description' => $item->description
                ]);
            } */
        }

        return response()->json(['Transaction updated successfully.', new TransactionResource($transaction)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json('Transaction deleted successfully');
    }
}
