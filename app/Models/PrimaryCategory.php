<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// SecondaryCategoryモデルの使用
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    use HasFactory;

    public function secondary()
    {
        // SecondaryCategory_tableと1対多の関係
        return $this->hasMany(SecondaryCategory::class);
    }
}
