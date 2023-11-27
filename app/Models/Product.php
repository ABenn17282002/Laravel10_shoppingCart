<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// shopモデルの追加
use App\Models\Shop;
// SecondaryCategoryモデルの追加
use App\Models\SecondaryCategory;
// stockモデルの使用
use App\Models\Stock;

class Product extends Model
{
    use HasFactory;

    // Products_tableの定義
    protected $fillable = [
        'shop_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    /**
    * Prouduct(製品)に関わるshop情報を全て取得
    */
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    /**
    * Prouduct(製品)に関わるSecondaryCategory情報を全て取得
    * メソッド名をモデル名から変える場合は第２引数必要
    */
    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    /**
    * Prouduct(製品)に関わる画像情報を全て取得
    * メソッド名をモデル名から変える場合は第２引数必要
    *  - (カラム名と同じメソッドは指定できないので名称変更)
    *  - 第２引数で_id がつかない場合は 第３引数で指定必要
    */
    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }

    /**
    * Prouduct(製品)に関わるStoc情報を全て取得
    * 1対多モデル
    */
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
