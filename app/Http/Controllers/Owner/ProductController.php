<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// productRequestクラスの使用
use App\Http\Requests\ProductRequest;
// 認証モデルの使用
use Illuminate\Support\Facades\Auth;
// DBFacadeの使用
use Illuminate\Support\Facades\DB;
// Image,Product,Ownerモデルの使用
Use App\Models\Image;
use App\Models\Product;
use App\Models\Owner;
// PrimaryCategoryに修正
use App\Models\PrimaryCategory;
// shopモデルの使用を追加
use App\Models\Shop;
// Stockモデルの使用
use App\Models\Stock;

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
        ->orderBy('sort_order')->get();

        // owner/products/create.balde.phpに上記変数付で返す
        return \view('owner.products.create',
        \compact('shops','images','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // try catch構文
        try {
            // transaction2回失敗時=> error(引数:$request)
            DB::transaction(function() use($request){

            /** Prouduct情報作成時にStock情報も同時作成 **/
            // 店舗名、店舗情報、価格等を登録
            $product = Product::create([
                'name' => $request->name,
                'information' => $request->information,
                'price' => $request->price,
                'sort_order' => $request->sort_order,
                'shop_id' => $request->shop_id,
                'secondary_category_id' => $request->category,
                'image1' => $request->image1,
                'image2' => $request->image2,
                'image3' => $request->image3,
                'image4' => $request->image4,
                'is_selling' => $request->is_selling
            ]);

            // 在庫情報作成
            Stock::create([
                // Product_tableより商品idを取得
                'product_id' => $product->id,
                // 入庫・在庫を増やす場合は1とする。
                'type' => 1,
                // 数量
                'quantity' => $request->quantity
            ]);

            },2);

        }catch(Throwable $e){
            // 例外処理の記録と画面表示
            Log::error($e);
            throw $e;
        }

        // owners.products.indexページへリダイレクト flashmessage
        return \redirect()->route('owner.products.index')
        ->with('info','商品登録が完了しました。');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // ProudctIDの取得
        $product = Product::findOrFail($id);

        // 製品数量を合計する
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        // shops_tableよりid,nameを取得
        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        // Images_tableよりid,title,filenameを更新順に取得
        $images = Image::where('owner_id', Auth::id())
        ->select('id','title','filename')
        ->orderBy('updated_at','desc')
        ->get();

        // withを用いて、関連するsecondaryも一緒に取得する.
        $categories = PrimaryCategory::with('secondary')
        ->get();

        // 上記変数をowner/products/edit.blade.phpに渡す
        return \view('owner.products.edit',
        \compact('product', 'quantity', 'shops','images', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        // validatation
        $request->validate([
            'current_quantity' => ['required', 'integer'],
        ]);

        // productidの取得
        $product = Product::findOrFail($id);
        // 製品数量を合計する
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        // 画面表示上の在庫数と違っている場合
        if($request->current_quantity !== $quantity){
            // ルートパラメータの取得
            $id = $request->route()->parameter('product');
            // redirect to owner/products/edit.blade.php+ flassmessage
            return redirect()->route('owner.products.edit', ['product' => $id])
            ->with('alert','在庫数が変更されています。再度確認してください');

        }else {

            // そうでなければ製品情報と在庫情報同時更新
            // トランザクション
            try{
                DB::transaction(function () use($request, $product) {

                    /* 製品情報更新処理  */
                    // idを元に取得したProduct情報から商品名等を取得
                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->sort_order = $request->sort_order;
                    $product->shop_id = $request->shop_id;
                    $product->secondary_category_id = $request->category;
                    $product->image1 = $request->image1;
                    $product->image2 = $request->image2;
                    $product->image3 = $request->image3;
                    $product->image4 = $request->image4;
                    $product->is_selling = $request->is_selling;

                    // 情報を保存(Createがないため必要)
                    $product->save();

                    // 在庫追加処理
                    if($request->type === '1')
                    {
                        $newQuantity = $request->quantity;
                    }
                    // 在庫削減処理の場合(-1)
                    if($request->type === '2')
                    {
                        $newQuantity = $request->quantity * -1;
                    }

                    /* 在庫情報更新処理 */
                    Stock::create([
                        // id=product情報より取得
                        'product_id' => $product->id,
                        // type:$request->typeより取得
                        'type' => $request->type,
                        // 数量：newQuantityより取得
                        'quantity' => $newQuantity
                    ]);

                }, 2);

            }catch(Throwable $e){
                Log::error($e);
                throw $e;
            }

            // redirect to owner/products/index.blade.php+ flassmessage
            return redirect()
            ->route('owner.products.index')
            ->with('info','商品情報を更新しました。');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
