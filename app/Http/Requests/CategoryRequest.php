<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'parent_id'=>['required','numeric'],
            'title'=>['required','string','max:255'],
            'status'=>['required','string','max:255','in:activated,deactivated'],
            'meta_description'=>['nullable','string','max:3000'],
            'meta_keyword'=>['nullable','string','max:3000'],
        ];
    }
}
