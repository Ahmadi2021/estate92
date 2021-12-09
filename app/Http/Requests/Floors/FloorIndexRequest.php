<?php

namespace App\Http\Requests\Floors;

use Illuminate\Foundation\Http\FormRequest;

class FloorIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('view-all-floors');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            // 'name' =>['required', 'max:50'],
            // 'description' =>['required'],

        ];
    }
}
