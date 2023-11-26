<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Ownerモデルの使用
use App\Models\Owner;
// Productモデルの使用
use App\Models\Product;

class Shop extends Model
{
    use HasFactory;

    /**
    * shop_tableの定義
    */
    protected $fillable =[
        'owner_id',
        'name',
        'information',
        'filename',
        'is_selling'
    ];

    /**
    * owner function
    * 店舗に関連しているOwner情報の取得
    */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
    * shopに関連しているproducts情報を取得
    * 1 対 多モデル
    */
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
