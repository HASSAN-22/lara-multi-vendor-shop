<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'brand_name'=>['required','string','max:255'],
            'brand_logo'=>['required','mimes:jpg,jpeg,png','max:'.config('app.image_size')],
            'brand_website'=>['nullable','string','max:255'],
            'status'=>['required','string','max:255','in:pending_confirmation,activated,deactivated']
        ];

        if(auth()->user()->isAdmin()){
            $validation['user_id'] = ['required','numeric','exists:users,id'];
        }
        if($this->isMethod('patch')){
            $validation['brand_logo'][0] = 'nullable';
        }
        return $validation;
    }
}
