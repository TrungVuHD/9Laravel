<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProfileSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'gender' => 'required|integer',
            'avatar_image' => 'image',
            'country' => 'required|max:100',
            'description' => 'max:255',
            'birthday_year' => 'integer|max:9999',
            'birthday_month' => 'integer|max:12',
            'birthday_day' => 'integer|max:31',
        ];
    }
}
