<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// 認証用モデルのインポート
use Illuminate\Foundation\Auth\User as Authenticatable;
// softDelete用クラス
use Illuminate\Database\Eloquent\SoftDeletes;
// shopモデルの追加
use App\Models\Shop;

class Owner extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *  model内容はUserモデルと同様
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * shop function
     * Ownerに関連している店舗情報の取得
     */
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
}
