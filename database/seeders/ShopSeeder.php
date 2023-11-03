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
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'サンシャインフィットネスセンター',
                'information' => 'ジム、ヨガクラス、パーソナルトレーニングを受けられます。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => 'フルーツフレッシュジュースバー',
                'information' => '新鮮なフルーツジュース、スムージー、サラダを提供しています。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'ブルームブティック',
                'information' => 'ファッションアパレル、アクセサリー、バッグを販売しています。',
                'filename' => '',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => 'シルバースクリーンシネマ',
                'information' => '最新映画の上映、ポップコーン、飲み物を提供しています.',
                'filename' => '',
                'is_selling' => true
            ],
        ]);
    }
}
