<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        $validation = [
            'title'=>['required','string','max:255'],
            'image'=>['required','mimes:jpg,jpeg,png','max:'.config('app.image_size')],
            'link'=>['required','string','max:255']
        ];

        if($this->isMethod('patch')){
            $validation['image'][0] = 'nullable';
        }
        return $validation;
    }
}
