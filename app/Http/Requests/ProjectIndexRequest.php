<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermissionTo('view-all-projects');
    }


    public function rules()
    {
        return [
            'start_date' => ['required','date_format:Y-m-d'],
            'end_date' => ['required','date_format:Y-m-d'],
        ];
    }
}
