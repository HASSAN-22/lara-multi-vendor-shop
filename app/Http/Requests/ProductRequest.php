<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "title" => ['required','string','max:255'],
            "category_id" => ['required','numeric','exists:categories,id'],
            "brand_id" => ['required','numeric','exists:brands,id'],
            "guarantee_id" => ['required','numeric','exists:guarantees,id'],
            "price" => ['required','numeric','regex:/^\d{1,13}(\.\d{1,4})?$/'],
            "discount" => ['required','numeric','digits_between:0,100'],
            "count" => ['required','numeric'],
            "is_original" => ['required','string','max:255','in:yes,no'],
            "status" => ['required','string','max:255','in:pending_confirmation,activated,deactivated'],
            "property_ids" =>['nullable','array'],
            "property_ids.*" =>['required','numeric','exists:properties,id'],
            "property_names" =>['nullable','array'],
            "property_names.*" =>['required','string','max:255'],
            "property_counts" =>['nullable','array'],
            "property_counts.*" =>['required','string','max:255'],
            "property_prices" =>['nullable','array'],
            "property_prices.*" =>['required','numeric','regex:/^\d{1,13}(\.\d{1,4})?$/'],
            "Specification_names" =>['nullable','array'],
            "Specification_names.*" =>['required','string','max:255'],
            "specification_descriptions" =>['nullable','array'],
            "specification_descriptions.*" =>['required','string','max:300'],
            "images" =>['required','array'],
            "images.*" =>['required','mimes:jpg,jpeg,png','max:'.config('app.image_size')],
            "short_description" =>['nullable','string','max:300'],
            "description" =>['nullable','string'],
            "meta_description" =>['nullable','string','max:3000'],
            "meta_keyword" =>['nullable','string','max:3000'],
        ];
        $user = auth()->user();
        if($user->isAdmin()){
            $validation['user_id']=['required','numeric','exists:users,id'];
        }
        if($this->isMethod('patch')){
            $validation['images'][0]='nullable';
            $validation['images.*'][0]='nullable';
        }
        return $validation;
    }
}
