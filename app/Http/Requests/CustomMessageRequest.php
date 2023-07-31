<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function customMessages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama maksimal :max karakter.',
            'name.min' => 'Nama minimal :min karakter.',
            'name.regex' => 'Gunakan huruf alfabet dan spasi untuk nama.',

            'username.required' => 'Username harus diisi.',
            'username.max' => 'Username maksimal :max karakter.',
            'username.min' => 'Username minimal :min karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Gunakan karakter alfanumerik untuk username.',

            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'password.required' => 'Password harus diisi.',
            'password.max' => 'Password maksimal :max karakter.',
            'password.min' => 'Password minimal :min karakter.',
            'password.regex' => 'Gunakan karakter alfanumerik untuk password.',
        ];
    }
}
