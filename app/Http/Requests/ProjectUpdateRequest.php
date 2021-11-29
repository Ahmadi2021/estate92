<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('update-project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>['required','string','max:255'],
            'description' =>['required'],
            'code' =>['required'],
            'phone_number' =>['required'],
            'images' => ['sometimes'],
        ];
    }

    public function messages()
    {
        return [
         'name.required' => ['name is emputy'],
         'description.required' =>['description is emputy'] ,
          'code.required' => ['code is emputy'],
          'phone_number.required' => ['phone number is emputy']

        ];
    }
}
