<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentIncrementPoint extends FormRequest
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
            'comment_id' => 'required|numeric|exists:comments,id'
        ];
    }
}