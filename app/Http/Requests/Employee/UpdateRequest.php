<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this->route('employee'));
        return [
            'cc' => 'required|numeric',
            'first_name' => 'required|string|max:200',
            'second_name' => 'nullable|string|max:200',
            'last_name' => 'required|string|max:200',
            'second_last_name' => 'nullable|string|max:200',
            'gender' => 'nullable|string|max:2',
            'birthdate' => 'required|date',
            'profile_photo' => 'nullable'
        ];
    }

    function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = new Response($validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }
    }
}
