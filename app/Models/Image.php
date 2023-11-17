<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Ownerモデルの追加
use App\Models\Owner;

class Image extends Model
{
    use HasFactory;

    /**
    * Image_tableの定義
    */
    protected $fillable =[
        'owner_id',
        'filename',
    ];

    /**
    * UPLOADした画像に紐づくOwner情報を全て取得
    */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
