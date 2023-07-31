<?php

namespace App\Http\Requests;

use App\Http\Requests\CustomMessageRequest;

class UserUpdateRequest extends CustomMessageRequest
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
        $user = auth()->user();

        $rules = [
            'name' => 'required|max:14|min:4|regex:/^[a-zA-Z ]*$/',
        ];

        if ($this->input('username') != $user->username) {
            $rules['username'] = 'required|min:6|max:10|unique:users|regex:/^[a-zA-Z0-9]*$/';
        }

        if ($this->input('email') != '' && $this->input('email') != $user->email) {
            $rules['email'] = 'required|unique:users|email:rfc,dns';
        }

        if ($this->input('password') != '') {
            $rules['password'] = 'required|min:5|max:12|regex:/^[a-zA-Z0-9]*$/';
        }

        return $rules;
    }

    public function messages()
    {
        return $this->customMessages();
    }
}
