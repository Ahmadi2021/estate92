<?php

namespace App\Http\Requests\Empolyee;

use Illuminate\Foundation\Http\FormRequest;

class EmpolyeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return auth()->user()->hasPermissionTo('create-empolyee');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => ['required', 'unique:employees,phone_number'],
            'cnic' => ['required', 'unique:employees,cnic'],
            'name' => ['required' ],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required'],
            'dob'   =>['required'],
            'level' => ['required'],
            'phone_ext' => ['required'],
            'address' => ['required'],
            'zip_code' => ['required'],

            
        ];
    }
}
