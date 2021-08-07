<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewProductRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'name' => ['required'],
            'slug' => ['required', 'unique:products,slug', 'alpha_dash'],
            'cost' => ['required','numeric', 'min:0'],
            'image' => ['required', 'mimes:png,jpg,jpeg', 'max:1024'],
            'description' => ['required']
        ];
    }
}
