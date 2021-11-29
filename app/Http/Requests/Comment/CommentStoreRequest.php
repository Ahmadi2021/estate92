<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentStoreRequest extends FormRequest
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
            'name'=>['required','string','max:5'],
            'body'=>['required'],
            'email' =>['required'],
            'rate' =>['required'],
            'type' =>['required', Rule::in(['blog', 'project', 'property'])],
            'commentable_id' => ['required']
            
        ];
    }
}
