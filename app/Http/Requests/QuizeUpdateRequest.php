<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "quize_name" =>
            "required|unique:quizes,quize_name,".$this->route('quize'),
            "expire_time" => 'required|interger',
            "status" => 'required',
            "questions" => 'required',
            "users" => 'required',
        ];
    }
}
