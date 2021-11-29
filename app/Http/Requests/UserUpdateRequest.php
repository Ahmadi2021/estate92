<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => ['required','email','unique:users'],
            'name' => ['required','string'],
            'password' =>['required'],
        ];
    }

    public function messages()
    {
        return [
        'email.required' => 'email is emputy',
        'name.required' =>'name is emputy' ,
        'password.required' => 'password is emputy'

        ];
    }
}
