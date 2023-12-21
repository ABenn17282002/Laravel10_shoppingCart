<?php

namespace App\Rules;

// PrimaryCategoryモデルとValidationRuleクラスの使用
use App\Models\PrimaryCategory;
use Illuminate\Contracts\Validation\Rule;

class UniquePrimarySortOrder implements Rule
{
    protected $categoryId;

    public function __construct($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function passes($attribute, $value)
    {
        // 編集モードの場合、現在のプライマリーカテゴリーIDを除外して同じソート順を持つ他のプライマリーカテゴリーをチェック
        return !PrimaryCategory::where('sort_order', $value)
            ->where('id', '!=', $this->categoryId)
            ->exists();
    }

    public function message()
    {
        return 'プライマリーカテゴリーのソート順は一意でなければなりません。';
    }
}
