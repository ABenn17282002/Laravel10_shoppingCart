<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// SecondaryCategoryモデルの使用
use App\Models\SecondaryCategory;
// SoftDelete用クラス
use Illuminate\Database\Eloquent\SoftDeletes;

class PrimaryCategory extends Model
{
    // ソフトデリートを有効化
    use HasFactory, SoftDeletes;

    // ソフトデリートのカラム名の設定
    protected $dates = ['deleted_at'];

    public function secondary()
    {
        // SecondaryCategory_tableと1対多の関係
        return $this->hasMany(SecondaryCategory::class);
    }
}
