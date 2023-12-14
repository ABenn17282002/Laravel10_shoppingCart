<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// DBFacadeの使用
use Illuminate\Support\Facades\DB;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 認証
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // PrimaryCategoryIDの取得
        $primaryCategoryId = $this->route('id');
        $ignoreId = $this->route('secondary_category');

        return [
            'primary_name' => 'required|string|max:255',

            'secondary.*.name' => [
                'required',
                'string',
                'max:255',

            ],
            'secondary.*.sort_order' => [
                'required',
                'integer',
                'distinct'
            ],

            'new_secondary.*.name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('secondary_categories', 'name')
                ->where('primary_category_id', $primaryCategoryId)
                ->ignore($ignoreId, 'id'),
            ],
            'new_secondary.*.sort_order' => [
                'sometimes',
                'required',
                'integer',
                'distinct',
                Rule::unique('secondary_categories', 'sort_order')
                ->where('primary_category_id', $primaryCategoryId)
                ->ignore($ignoreId, 'id'),
            ],
        ];
    }

    // フォームvalidationMessage
    public function messages()
    {
        return [
            // PrimaryCategory
            'primary_name.required' => 'メインカテゴリー名は必須です。',
            'primary_name.string' => 'メインカテゴリー名は文字列である必要があります。',
            'primary_name.max' => 'メインカテゴリー名は最大255文字までです。',

            // SecondaryCategory
            'secondary.*.name.required' => 'セカンダリーカテゴリー名は必須です。',
            'secondary.*.name.string' => 'セカンダリーカテゴリー名は文字列である必要があります。',
            'secondary.*.name.max' => 'セカンダリーカテゴリー名は最大255文字までです。',
            'secondary.*.sort_order.required' => 'セカンダリーカテゴリーのソート順は必須です。',
            'secondary.*.sort_order.integer' => 'セカンダリーカテゴリーのソート順は整数である必要があります。',
            'secondary.*.sort_order.distinct' => 'セカンダリーカテゴリーのソート順は一意である必要があります。',

            // New_SecondaryCategory
            'new_secondary.*.name.required' => '新しいセカンダリーカテゴリー名は必須です。',
            'new_secondary.*.name.string' => '新しいセカンダリーカテゴリー名は文字列である必要があります。',
            'new_secondary.*.name.max' => '新しいセカンダリーカテゴリー名は最大255文字までです。',
            'new_secondary.*.sort_order.required' => '新しいセカンダリーカテゴリーのソート順は必須です。',
            'new_secondary.*.sort_order.integer' => '新しいセカンダリーカテゴリーのソート順は整数である必要があります。',
            'new_secondary.*.sort_order.distinct' => '新しいセカンダリーカテゴリーのソート順は一意である必要があります。',
            'new_secondary.*.name.unique_secondary_name' => '指定された新しいセカンダリーカテゴリー名は既に使用されています。',
            'new_secondary.*.sort_order.unique_secondary_sort_order' => '指定された新しいソート順は既に使用されています。',
        ];

    }

}
