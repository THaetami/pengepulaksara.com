<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SastraStoreRequest extends FormRequest
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
            'title' => 'required|max:30',
            'body' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'judul tidak boleh kosong',
            'title.max' => 'judul maksimal 30 karakter',
            'body.required' => 'body tidak boleh kosong',
        ];
    }

    /**
     * Prepare the validated data before using it in the controller.
     *
     * @return array<string, mixed>
     */
    public function validatedData()
    {
        $validated = $this->validated();
        $validated['author_id'] = auth()->user()->id;
        $validated['penulis'] = auth()->user()->username;
        $validated['slug'] = Str::uuid();

        return $validated;
    }
}
