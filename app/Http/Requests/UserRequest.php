<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'=>['required','string','max:255'],
            'access'=>['required','string','max:255','in:admin,vendor,customer'],
            'status'=>['required','string','max:255','in:activated,deactivated'],
            'email'=>['required','string','max:255','email'],
            'password'=>['required','string','min:6','max:255'],
        ];

        if($this->isMethod('patch')){
            $validation['password'][0] = 'nullable';
        }
        return $validation;
    }
}
