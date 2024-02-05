<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 商品追加のためのメソッド
    public function add(Request $request)
    {
        $productId = $request->input('productId');
        $quantity = $request->input('quantity');

        // これらの値を含むJSONレスポンスを返す
        return response()->json(['productId' => $productId, 'quantity' => $quantity]);
    }
}
