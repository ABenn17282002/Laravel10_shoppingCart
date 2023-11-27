<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            // Productクラスの追加
            ProductSeeder::class,
            // Stockクラスの追加
            StockSeeder::class,
        ]);
    }
}
