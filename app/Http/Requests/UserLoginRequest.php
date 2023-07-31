<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomMessageRequest;

class UserLoginRequest extends CustomMessageRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ];
    }

    public function messages()
    {
        return $this->customMessages();
    }
}

