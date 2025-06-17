<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',

            'category_ids' => 'required|array|min:1',
        'category_ids.*' => ['exists:categories,id'],

        'condition' => ['required', 'in:1,2,3,4,5,6'], // 状態は1〜6の文字列（数字）
        'name' => ['required', 'string', 'max:255'], // 商品名
        'brand' => ['nullable', 'string', 'max:255'], // ブランド名（任意）
        'description' => ['required', 'string', 'max:1000'], // 説明
        'price' => ['required', 'integer', 'min:1', 'max:9999999'], // 金額
    ];
}

public function messages(): array
{
    return [
        'image.required' => '商品画像を選択してください。',
        'image.image' => '画像ファイルをアップロードしてください。',
        'image.max' => '画像サイズは2MB以下にしてください。',

        'category_ids.required' => 'カテゴリーを選択してください。',
        'category_ids.array' => 'カテゴリーの形式が正しくありません。',
        'category_ids.*.exists' => '選択されたカテゴリーは無効です。',

        'condition.required' => '商品の状態を選択してください。',
        'condition.in' => '正しい商品の状態を選択してください。',

        'name.required' => '商品名を入力してください。',
        'name.max' => '商品名は255文字以内で入力してください。',

        'brand.max' => 'ブランド名は255文字以内で入力してください。',

        'description.required' => '商品説明を入力してください。',
        'description.max' => '商品説明は1000文字以内で入力してください。',

        'price.required' => '販売価格を入力してください。',
        'price.integer' => '販売価格は整数で入力してください。',
        'price.min' => '販売価格は1円以上で入力してください。',
        'price.max' => '販売価格は9,999,999円以下で入力してください。',
    ];

    }
}