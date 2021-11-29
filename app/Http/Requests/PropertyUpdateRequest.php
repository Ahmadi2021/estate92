<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('update-property');;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' =>['required', Rule::in(config('enum.purposes'))],
            'name' =>['required','string','max:50'],
            'property_type' =>['required',Rule::in(config('enum.property_types'))],
            'address' => ['required'],
            'size' => ['required'],
             'price' => ['required'],
             'no_of_bed'=> ['required'],
             'no_of_bathroom' =>['required'],
             'description' => ['required'],
             'status' => ['required', Rule::in(config('enum.property_statuses'))],
             'user_id' =>['required'],

        ];
    }
}
