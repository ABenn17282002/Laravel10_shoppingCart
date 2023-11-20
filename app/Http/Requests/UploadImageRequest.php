<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
        return [
            // 画像のUpload形式:jpeg,jpg,pngのみ、最大:2MBまで
            'image'=>'image|mimes:jpg,jpeg,png|max:2048',
            // 複数画像Uploadする際のバリデーション
            'files.*.image' =>'required|image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    /**
    * Error Message
    */
    public function messages()
    {
        return [
            'image' => '指定されたファイルが画像ではありません。',
            'mimes' => '指定された拡張子（jpg/jpeg/png）ではありません。',
            'max' => 'ファイルサイズは2MB以内にしてください。',
        ];
    }
}
