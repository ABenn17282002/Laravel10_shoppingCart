<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// Product,Stockモデルの使用
use App\Models\Product;
use App\Models\Stock;

class DatabaseSeeder extends Seeder
{
    /**
     * データベースに対するデータ設定の実行
     */
    public function run(): void
    {
        $this->call([
            // Admin,OwnerSeederクラスの読込み
            AdminSeeder::class,
            OwnerSeeder::class,
            // shopクラスの追加
            ShopSeeder::class,
            // Imageクラスの追加
            ImageSeeder::class,
            // CategorySeederクラスの追加
            CategorySeeder::class,

            // Userクラスの追加
            UserSeeder::class,
        ]);
        // 商品+在庫ダミーテーブル(※関連付けが必要)
        Product::factory(100)->create();
        Stock::factory(100)->create();
    }
}
