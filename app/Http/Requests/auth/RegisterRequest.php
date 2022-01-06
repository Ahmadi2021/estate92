<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email'=> ['required', 'string', 'max:50', 'unique:users,email'],
            'password' => ['required'],
            'role' => ['required', Rule::in(['agency','customer'])],

            // share field between agency and custommer
           'name' => ['required', 'string','max:50'],
           'phone_number' =>['required'],
           'phone_ext' =>['required'],
            //agency required
           'logo' => ['required_if:role,agency'],
           'qr_code' => ['required_if:role,agency'],
           'uuid' => ['required_if:role,agency'],
           // customer required
           'address_1' => ['required_if:role,customer'],
           'address_2' => ['required_if:role,customer'],
           'zip_code' => ['required_if:role,customer'],
           'website' => ['required_if:role,customer'],
           'gender' => ['required_if:role,customer', Rule::in(config('enum.genders'))],





        ];
    }
}
