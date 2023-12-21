<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// DBFacadeの使用
use Illuminate\Support\Facades\DB;
// UniquePrimarySortOrderクラスの使用
use App\Rules\UniquePrimarySortOrder;

class CategoryRequest extends FormRequest
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

        $rules = [
            'primary_name' => 'required|string|max:255',
            'primary_sort_order' => [
                'required',
                'integer',
                'min:1',
                new UniquePrimarySortOrder($primaryCategoryId), // カスタムバリデーションルールを使用
            ],
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
                'nullable',
                'string',
                'max:255',
                // 既存で使用されている名前は不可
                Rule::unique('secondary_categories', 'name')
                ->where('primary_category_id', $primaryCategoryId)
                ->ignore($ignoreId, 'id'),
                // IDが登録されているときは新規カテゴリーも入力
                function ($attribute, $value, $fail) {
                    $sortOrderField = str_replace('.name', '.sort_order', $attribute);
                    $sortOrderValue = $this->input($sortOrderField);
                    if ((empty($value) && !empty($sortOrderValue)) || (!empty($value) && empty($sortOrderValue))) {
                        $fail('新規カテゴリーの名称とソート順の両方を入力してください。');
                    }
                },
            ],
            'new_secondary.*.sort_order' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                'distinct',
                // 既存で使用されているIDは不可
                Rule::unique('secondary_categories', 'sort_order')
                ->where('primary_category_id', $primaryCategoryId)
                ->ignore($ignoreId, 'id'),
                // カテゴリー名が登録されているときはIDも入力
                function ($attribute, $value, $fail) {
                    $nameField = str_replace('.sort_order', '.name', $attribute);
                    $nameValue = $this->input($nameField);
                    if ((empty($value) && !empty($nameValue)) || (!empty($value) && empty($nameValue))) {
                        $fail('新規カテゴリーの名称とソート順の両方を入力してください。');
                    }
                },
            ],
        ];

        return $rules;
    }

    // フォームvalidationMessage
    public function messages()
    {
        return [
            // PrimaryCategory
            'primary_name.required' => 'メインカテゴリー名は必須です。',
            'primary_name.string' => 'メインカテゴリー名は文字列である必要があります。',
            'primary_name.max' => 'メインカテゴリー名は最大255文字までです。',
            'primary_sort_order.required'=> 'メインカテゴリーのソート順は必須です。',
            'primary_sort_order.integer' => '新しいセカンダリーカテゴリーのソート順は整数である必要があります。',
            'primary_sort_order.min' => 'メインカテゴリーのソート順は整数である必要があります。',

            // SecondaryCategory
            'secondary.*.name.required' => 'セカンダリーカテゴリー名は必須です。',
            'secondary.*.name.string' => 'セカンダリーカテゴリー名は文字列である必要があります。',
            'secondary.*.name.max' => 'セカンダリーカテゴリー名は最大255文字までです。',
            'secondary.*.sort_order.required' => 'セカンダリーカテゴリーのソート順は必須です。',
            'secondary.*.sort_order.integer' => 'セカンダリーカテゴリーのソート順は整数である必要があります。',
            'secondary.*.sort_order.distinct' => 'セカンダリーカテゴリーのソート順は一意である必要があります。',

            // New_SecondaryCategory
            'new_secondary.*.name.string' => '新しいセカンダリーカテゴリー名は文字列である必要があります。',
            'new_secondary.*.name.max' => '新しいセカンダリーカテゴリー名は最大255文字までです。',
            'new_secondary.*.sort_order.integer' => '新しいセカンダリーカテゴリーのソート順は整数である必要があります。',
            'new_secondary.*.sort_order.min' => '新しいセカンダリーカテゴリーのソート順は整数である必要があります。',
            'new_secondary.*.sort_order.distinct' => '新しいセカンダリーカテゴリーのソート順は一意である必要があります。',
            'new_secondary.*.name.unique_secondary_name' => '指定された新しいセカンダリーカテゴリー名は既に使用されています。',
            'new_secondary.*.sort_order.unique' => '指入力された新規カテゴリのソート順は既に存在しています。別の値を試してください。',
        ];

    }

}
