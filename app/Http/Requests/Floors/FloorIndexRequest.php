<?php

namespace App\Http\Requests\Floors;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            
            'project_id' =>['required', 'numeric', Rule::exists(Project::class, 'id')],
            // 'description' =>['required'],

        ];
    }
}
