<?php

namespace App\Http\Controllers\API;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class WalletController extends BaseController
{
    public function transactions(Request $request)
{
    $user = User::where('id',$request->user_id)->first();
    if (!$user) {
        return response()->json([
            'status_code' => 404,
            'message' => 'user not found.'
        ], 404);
        }
    $transactions = Transaction::where('user_id', $request->user_id)->paginate(10); // 10 transactions per page

    return response()->json([
        'status_code' => 200,
        'order' => ($transactions)
    ], 200);
}

 public function latestTransactions(Request $request)
{
    $user = User::where('id',$request->user_id)->first();
    if (!$user) {
        return response()->json([
            'status_code' => 404,
            'message' => 'user not found.'
        ], 404);
        }
        $transactions = Transaction::where('user_id', $request->user_id)
        ->latest()
        ->take(10) // Retrieve the latest 10 transactions
        ->get();

        return response()->json([
            'status_code' => 200,
            'transactions' => ($transactions)
        ], 200);
}


public function calculateTotalAmount(Request $request)
    {
    $user = User::where('id',$request->user_id)->first();
    if (!$user) {
        return response()->json([
            'status_code' => 404,
            'message' => 'user not found.'
        ], 404);
        }
        $totalAmount =Transaction::where('user_id', $request->user_id)->sum('amount');

        return response()->json([
            'status_code' => 200,
            'total_amount' => ($totalAmount)
        ], 200);
        }
}
