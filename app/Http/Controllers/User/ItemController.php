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
    // indexページの表示
    public function index()
    {
        // ProductTableの内容を20件ごとに取得
        // $products = Product::paginate(20);

        /* Stockの合計をグループ化->数量が1以上 */
        $stocksQuery = DB::table('t_stocks')
        // select `product_id`, sum(quantity) as quantity from `t_stocks` 
        ->select('product_id', DB::raw('sum(quantity) as quantity'))
        // group by `product_id` 
        ->groupBy('product_id')
        // having `quantity` > ?
        ->having('quantity', '>', 1);

        $stocksSql = $stocksQuery->toSql(); // 生のSQLクエリを取

        $productsQuery = DB::table('products')
        ->joinSub($stocksQuery, 'stock', function($join){
            // Join product on products.id = stock.product_id
            $join->on('products.id', '=', 'stock.product_id');
        })
        // Join shops on products.shop_id = shops.id
        ->join('shops', 'products.shop_id', '=', 'shops.id')
        // where shops.is_selling =1
        ->where('shops.is_selling', true)
        // where products.is_selling =1
        ->where('products.is_selling', true);

        $productsSql = $productsQuery->toSql(); // 生のSQLクエリを取得

        dd($stocksSql, $productsSql);

        return view('user.index',\compact('products'));
    }
}
