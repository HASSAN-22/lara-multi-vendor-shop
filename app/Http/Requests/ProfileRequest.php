<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'address'=>['required','string','max:255'],
            'city'=>['required','string','max:255'],
            'province'=>['required','string','max:255'],
            'plak'=>['required','numeric','unique:profiles,plak'],
            'national_id'=>['required','numeric','unique:profiles,national_id'],
            'name'=>['required','string','max:255'],
            'email'=>['required','string','max:255','email','unique:users,email'],
            'avatar'=>['nullable','mimes:jpg,jpeg,png','max:'.config('app.image_size')]
        ];

        if($this->user()->isVendor()){
            $validation['shop_name'] = ['required','string','max:255','unique:users,shop_name'];
        }

        if($this->isMethod('patch')){
            $validation['email'][4] = 'unique:users,id,email';
            $validation['shop_name'][3] = 'unique:profiles,id,shop_name';
            $validation['national_id'][2] = 'unique:profiles,id,national_id';
            $validation['plak'][2] = 'unique:profiles,id,plak';
        }
        return $validation;
    }
}
