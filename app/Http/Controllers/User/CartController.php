<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 認証モデルの追加
use Illuminate\Support\Facades\Auth;
// Cartモデルの追加
use App\Models\Cart;
// Userモデルの追加
use App\Models\User;

class CartController extends Controller
{
    // indexPage用メソッド
    public function index()
    {
        // userの取得
        $user = User::findOrFail(Auth::id());
        // user⇔productとの多対多リレーション
        $products = $user->products;
        // 総額表示
        $totalPrice = 0;

        // 製品を1つずつ取得
        foreach($products as $product){
            // 製品の価格 * 中間テーブルの数量の数
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return \view('user.cart', compact('products', 'totalPrice'));
    }

    // 商品追加のためのメソッド
    public function add(Request $request)
    {
        // Cartに商品があるかどうか
        $itemInCart = Cart::where('user_id',Auth::id())
        ->where('product_id',$request->input('productId'))->first();

        if($itemInCart){
            // cart内に商品がある場合、数量追加
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();

        }else{
            // cart内に商品がない場合、新規追加
            Cart::Create([
                'user_id'=> Auth::id(),
                'product_id'=>$request->input('productId'),
                'quantity'=>$request->quantity
            ]);
        }
        // これらの値を含むJSONレスポンスを返す
        return response()->json(['itemInCart' => $itemInCart]);
    }

    // Cartの削除
    public function delete($id)
    {
        // Cart内の選択したproduct_idを削除
        Cart::where('product_id',$id)
        ->where('user_id',Auth::id())
        ->delete();

        // cart/indexにリダイレクト
        return redirect()->route('user.cart.index')
        ->with('alert','カート情報を削除しました');;
    }
}