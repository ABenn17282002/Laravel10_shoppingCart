<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    use HasFactory;

    // SeconadaryCategoryに関するテーブル定義
    protected $fillable = [
        'name',
        'sort_order',
        'primary_category_id',
    ];

    /**
    * secondary_tableに関係するprimary_table情報を全てを取得
    */
    public function primary()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }
}
