<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function getWallet($id){
        $wallet = Wallet::where('user_id', $id)->first();
        // dd($wallet);
        return response()->json($wallet);
    }

    public function deposit(Request $request){
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $wallet->balance += $request->amount;
        $wallet->save();
        return response()->json($wallet);
    }

    public function withdraw(Request $request){
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        if($wallet->balance >= $request->amount) {
            $wallet->balance -= $request->amount;
            $wallet->save();
            return response()->json($wallet,200);
        }
        return response()->json(['message'=>'Insufficient funds'],400);
    }
    public function pay(Request $request){
        $wallet = Wallet::where('user_id', $request->user_id)->first();
        $wallet->balance -= $request->amount;
        $wallet->save();
        return response()->json($wallet,200);
    }
}
