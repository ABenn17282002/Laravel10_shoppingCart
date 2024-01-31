<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; // DBクラスのインポート
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 店舗情報に関する内容
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'グリーンビューティーサロン',
                'information' => 'フェイシャルトリートメント、マッサージ、ネイルケアを提供しています。',
                'filename' => 'shop1.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'HomeDecorHaven',
                'information' => 'スタイリッシュなホームデコレーションアイテムをご覧ください。',
                'filename' => 'shop2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => 'フルーツフレッシュジュースバー',
                'information' => '新鮮なフルーツジュース、スムージー、サラダを提供しています。',
                'filename' => 'shop3.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'ブルームブティック',
                'information' => 'ファッションアパレル、アクセサリー、バッグを販売しています。',
                'filename' => 'shop4.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => 'OutdoorAdventureGear',
                'information' => 'アウトドアアクティビティ向けの装備とアクセサリーを提供しています。',
                'filename' => 'shop5.jpg',
                'is_selling' => true
            ],
        ]);
    }
}
