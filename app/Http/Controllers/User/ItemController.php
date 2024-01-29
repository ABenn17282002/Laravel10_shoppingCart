<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Productクラスの使用
use App\Models\Product;
// DB Facades使用
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    // 処理の共通化(商品取得処理)
    private function getAvailableProductsQuery()
    {
        // Stockの合計をグループ化->数量が1以上
        $stocks = DB::table('t_stocks')
        ->select('product_id', DB::raw('sum(quantity) as quantity'))
        ->groupBy('product_id')
        ->having('quantity', '>', 1);

        // ベースのクエリを作成
        return DB::table('products')
        ->joinSub($stocks, 'stock', function($join){
            // Join product on products.id = stock.product_id
            $join->on('products.id', '=', 'stock.product_id');
        })
        // Join shops on products.shop_id = shops.id
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        // inner join `secondary_categories` on `products`.`secondary_category_id` = `secondary_categories`.`id`
        ->join('secondary_categories', 'products.secondary_category_id', '=',
        'secondary_categories.id')
        // inner join `images` as `image*` on `products`.`image*` = `image*`.`id` 
        ->join('images as image1', 'products.image1', '=', 'image1.id')
        ->join('images as image2', 'products.image2', '=', 'image2.id')
        ->join('images as image3', 'products.image3', '=', 'image3.id')
        ->join('images as image4', 'products.image4', '=', 'image4.id')
        // where shops.is_selling =1
        ->where('shops.is_selling', true)
        // where products.is_selling =1
        ->where('products.is_selling', true)
        // select products.id,name,price,sort_order,information,
        // secondary_categories.name,image1.filename
        ->select('products.id as id', 'products.name as name', 'products.price'
        ,'products.sort_order as sort_order'
        ,'products.information', 'secondary_categories.name as category'
        ,'image1.filename as filename');
    }

    // indexページの表示
    public function index()
    {
        $products = $this->getAvailableProductsQuery()->paginate(10);
        return view('user.index', compact('products'));
    }

    // Login時ページの商品一覧
    public function memberIndex()
    {
        $products = $this->getAvailableProductsQuery()->paginate(10);
        return view('user.index', compact('products')); 
    }

    // 商品詳細ページ
    public function show($id)
    {
        // 製品IDがあれば情報取得,ない場合Not Found
        $product = Product::findorFail($id);
        return \view('user.show',\compact('product'));
    }
}
