<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Owner;   // Ownerモデルの使用

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
}
