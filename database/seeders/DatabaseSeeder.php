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
        // Admin,OwnerSeederクラスの読込み
        $this->call([
            AdminSeeder::class,
            OwnerSeeder::class,
            // shopクラスの追加
            ShopSeeder::class,
            // Imageクラスの追加
            ImageSeeder::class,
            // CategorySeederクラスの追加
            CategorySeeder::class
        ]);
    }
}
