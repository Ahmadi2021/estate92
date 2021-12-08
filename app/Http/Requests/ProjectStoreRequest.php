<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('create-project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string','max:50'],
            'description' => ['required'],
            'code'   => ['required'],
            'phone_number' => ['required'],
            'address' =>['required'],

            // floor fields 
            'project_images' => ['required', 'min:1'],
            'project_images.*' => ['required', 'image', 'mimes:jpg,png,jpeg', "max:2048"]
        ];
    }
    

    public function messages()
    {
        return [
            'image.min' => 'The minumum number of images must be 2'
        ];
    }
}
