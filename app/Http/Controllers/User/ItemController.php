<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Productクラスの使用
use App\Models\Product;

class ItemController extends Controller
{
    // indexページの表示
    public function index()
    {
        // ProductTableの内容を20件ごとに取得
        $products = Product::paginate(20);
        return view('user.index',\compact('products'));
    }
}
