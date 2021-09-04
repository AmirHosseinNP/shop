<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfferRequest extends FormRequest
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
            'code' => ['required', 'min:4'],
            'starts_at' => ['array'],
            'expires_at' => ['array'],
            'starts_at.0' => ['required', 'numeric', 'min:1400'],
            'starts_at.1' => ['required', 'numeric', 'between:1,12'],
            'starts_at.2' => ['required', 'numeric', 'between:1,31'],
            'starts_at.3' => ['required'],
            'expires_at.0' => ['required', 'numeric', 'min:1400'],
            'expires_at.1' => ['required', 'numeric', 'between:1,12'],
            'expires_at.2' => ['required', 'numeric', 'between:1,31'],
            'expires_at.3' => ['required']
        ];
    }
}
