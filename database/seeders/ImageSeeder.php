<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// DB用Facadeをインポート
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
// tableにデータを構築
DB::table('images')->insert([
    [
        'owner_id' => 1,
        'filename' => 'sample1.jpeg',
        'title' => 'グリーンエッセンス エコシャンプー'
    ],
    [
        'owner_id' => 1,
        'filename' => 'sample2.jpeg',
        'title' => 'ナチュラルハーモニー オーガニックフェイシャルクリーム'
    ],
    [
        'owner_id' => 1,
        'filename' => 'sample3.jpeg',
        'title' => 'ハーバルリフレッシュ バスボムコレクション'
    ],
    [
        'owner_id' => 1,
        'filename' => 'sample4.jpeg',
        'title' => 'バンブーケア ソフトヘアブラシ'
    ],
    [
        'owner_id' => 1,
        'filename' => 'sample5.jpeg',
        'title' => 'アロマグリーン エッセンシャルオイルセット'
    ],
    [
        'owner_id' => 1,
        'filename' => 'sample6.jpeg',
        'title' => 'グリーンティーエンリッチ フェイシャルマスク'
    ]]);
    }
}
