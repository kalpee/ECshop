<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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

    // 画像アップロード設定
    public function rules()
    {
        return [
            'image' => 'image|mimes:jpg,jpeg,png|max:8192',
            'files.*.image' => 'required|image|mimes:jpg,jpeg,png|max:8192',
        ];
    }

    // アップロードエラーメッセージ設定
    public function messages()
    {        
        return [
            'image' => '指定されたファイルが画像ではありません。',
            'mines' => '指定された拡張子（jpg/jpeg/png）ではありません。',
            'max' => 'ファイルサイズは8MB以内にしてください。',
            ];
        }
    }
