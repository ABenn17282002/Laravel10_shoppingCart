<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Ownerモデルの使用
use App\Models\Owner;

class Shop extends Model
{
    use HasFactory;

    /**
     * owner function
     * 店舗に関連しているOwner情報の取得
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

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
}
