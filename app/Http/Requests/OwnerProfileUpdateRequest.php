<?php

namespace App\Http\Requests;

use App\Models\Owner; // Ownerモデル
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OwnerProfileUpdateRequest extends FormRequest
{
    /**
     * 認証済みユーザのみ可
     */
    public function authorize(): bool
    {
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
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(Owner::class)->ignore($this->user()->id)],
        ];
    }
}
