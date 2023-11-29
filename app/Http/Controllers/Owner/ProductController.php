<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// 認証モデルの使用
use Illuminate\Support\Facades\Auth;
// Image,Product,Owner,productsモデルの使用
Use App\Models\Image;
use App\Models\Product;
use App\Models\Owner;
// PrimaryCategoryに修正
use App\Models\PrimaryCategory;
// shopモデルの使用を追加
use App\Models\Shop;

class ProductController extends Controller
{
    /* コンストラクタの設定 */
    public function __construct()
    {
        $this->middleware('auth:owners');

        // コントローラミドルウェア
        $this->middleware(function ($request, $next) {
            // 製品IDの取得
            $id = $request->route()->parameter('product');
            // null判定
            if(!is_null($id)){
                // shopに紐づくOwnerIdの取得
                $productsOwnerId= Product::findOrFail($id)->shop->owner->id;
                // 文字列→数値に変換
                $proudcutId = (int)$productsOwnerId;
                // 製品IDが認証済IDでない場合
                if($proudcutId  !== Auth::id()){
                    abort(404); // 404画面表示
                }
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* Ownerモデルと関連データをEagerLoadしてデータベースクエリを最適化
        * 1. Ownerモデルに紐づけ各オーナーの店舗と商品を取得
        * 2. 取得した商品情報と連携し、imageFirstモデルでIDと画像の最初を取得
        */
        $owners = Owner::with(['shop.product.imageFirst'])
        ->where('id', Auth::id())
        ->get();

        // 商品を3件ごとに表示する
        $perPage = 3;
        // ループでOwner毎取得し、ownerの商品IDと一致した部分を取得する
        $owners->each(function ($owner) use ($perPage) {
            $owner->shop->product = Product::where('shop_id', $owner->shop->id)->paginate($perPage);
        });

        // redirect owner/products/index.blade.php
        return view('owner.products.index', compact('owners'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // shops_tableよりid,nameを取得
        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')->get();

        // Images_tableよりid,title,filenameを更新順に取得
        $images = Image::where('owner_id', Auth::id())
        ->select('id','title','filename')
        ->orderBy('updated_at','desc')
        ->get();

        // withを用いて、関連するsecondaryも一緒に取得する.
        $categories = PrimaryCategory::with('secondary')
        ->get();

        // owner/products/create.balde.phpに上記変数付で返す
        return \view('owner.products.create',
        \compact('shops','images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
