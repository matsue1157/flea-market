<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => ['required', 'string', 'max:255'],
            'birthdate' => ['nullable', 'date'],
        ];
    }
    public function messages()
    {
        return [
            'nickname.required' => 'ニックネームは必須です。',
            'nickname.max' => 'ニックネームは255文字以内で入力してください。',
            'birthdate.date' => '生年月日は正しい形式で入力してください。',
        ];
    }
}
