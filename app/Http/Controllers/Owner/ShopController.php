<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Shopモデル
use App\Models\Shop;
// Auth認証用モデル
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /*ログイン済みOwnerのみ表示させるため
    コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:owners');

        // コントローラミドルウェア
        $this->middleware(function ($request, $next) {

            // shop_idの取得
            $id = $request->route()->parameter('shop');

            // null判定
            if(!is_null($id)){
                // shopに紐づくOwnerIdの取得
                $shopsOwnerId= shop::findOrFail($id)->owner->id;
                // 文字列→数値に変換
                $shopId = (int)$shopsOwnerId;
                // 認証済のidを取得
                $ownerId = Auth::id();
                // shopIDとownerIDが不一致の場合
                if($shopId !== $ownerId){
                    abort(404); // 404画面表示
                }
        }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ownerid = 認証ユーザが一致したユーザを出力する
        $shops = Shop::where('owner_id', Auth::id())->get();

        // owner/index.balde.phpにshops変数付で返す
        return view('owner.shops.index',compact('shops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // idがあればそのページ,なければ404
        dd(Shop::findOrFail($id));
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

    }
}
