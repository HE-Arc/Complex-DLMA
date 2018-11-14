<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DlmaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // to adapt to users privileges
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"        => "required|max:190",
            "choice_1"     => "required|max:75",
            "choice_2"     => "required|max:75",
        ];
    }

    /**
     * Set custom error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "title.required" => "A title is required.",
            "choice_1.required"  => "Two choices are required.",
            "choice_2.required"  => "Two choices are required.",
        ];
    }
}
