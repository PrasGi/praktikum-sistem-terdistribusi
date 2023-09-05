<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('confirmed_at', null)->get();

        return response()->json([
            'status_error' => false,
            'message' => 'Transactions retrieved successfully',
            'data' => $transactions,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make([
            'user_id' => $request->user_id,
            'image' => $request->image,
        ], [
            'user_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_error' => true,
                'message' => $validator->errors(),
            ]);
        }

        $payload = [
            'user_id' => $request->user_id,
            'image' => env('APP_URL') . '/storage/' . $request->file('image')->store('images/transactions'),
        ];

        if ($transaction = Transaction::create($payload)) {
            return response()->json([
                'status_error' => false,
                'message' => 'Transaction created successfully',
                'data' => $transaction,
            ]);
        }

        return response()->json([
            'status_error' => true,
            'message' => 'Transaction failed to create',
        ]);
    }

    public function confirm(Transaction $transaction)
    {
        $transaction->confirmed_at = now();
        $transaction->save();

        return response()->json([
            'status_error' => false,
            'message' => 'Transaction confirmed successfully',
            'data' => $transaction,
        ]);
    }

    public function getStatus($uuid)
    {
        $transaction = Transaction::where('user_id', $uuid)->where('confirmed_at', '!=',  null)->first();

        if ($transaction) {
            return response()->json([
                'status_error' => false,
                'message' => 'Transaction retrieved successfully',
                'status' => true,
            ]);
        }

        return response()->json([
            'status_error' => false,
            'message' => 'Transaction retrieved successfully',
            'status' => false,
        ]);
    }
}
