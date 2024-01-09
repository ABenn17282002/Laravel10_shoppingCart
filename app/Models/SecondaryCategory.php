<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// SoftDelete用クラス
use Illuminate\Database\Eloquent\SoftDeletes;


class SecondaryCategory extends Model
{
    // ソフトデリートを有効化
    use HasFactory, SoftDeletes;

    // SeconadaryCategoryに関するテーブル定義
    protected $fillable = [
        'name',
        'sort_order',
        'primary_category_id',
        'deleted_at',
    ];

    /**
    * secondary_tableに関係するprimary_table情報を全てを取得
    */
    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }
}
