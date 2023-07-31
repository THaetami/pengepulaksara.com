<?php

namespace App\Http\Requests;


class UserRegisterRequest extends CustomMessageRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:14', 'min:4', 'regex:/^[a-zA-Z ]*$/'],
            'username' => ['required', 'max:10', 'min:6', 'unique:users', 'regex:/^[a-zA-Z0-9]*$/'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'max:12', 'min:5', 'regex:/^[a-zA-Z0-9]*$/'],
        ];
    }

    public function messages()
    {
        return $this->customMessages();
    }
}
