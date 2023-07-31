<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'commentar' => 'required',
            'sastra_id' => 'required|exists:sastras,id,is_delete,0',
        ];
    }

    public function messages()
    {
        return [
            'commentar.required' => 'komentar tidak boleh kosong',
            'sastra_id.required' => 'sastra_id tidak boleh kosong',
            'sastra_id.exists' => 'sastra tidak ditemukan',
        ];
    }
}
