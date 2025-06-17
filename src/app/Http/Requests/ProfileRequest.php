<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'nickname' => ['required', 'string', 'max:50'],
            'birthdate' => ['required', 'date'],
            'gender' => ['required', 'in:male,female,other'],
        ];
    }
    public function messages(): array
    {
        return [
            'nickname.required' => 'ニックネームを入力してください',
            'nickname.max' => 'ニックネームは50文字以内で入力してください',
            'birthdate.required' => '生年月日を入力してください',
            'birthdate.date' => '生年月日には有効な日付を入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別の値が不正です',
        ];
    }
}