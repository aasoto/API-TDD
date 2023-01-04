<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:500',
            'description' => 'required|string',
            'start_execution' => 'required|date',
            'end_execution' => 'nullable|date',
            'contractor_company_id' => 'required|integer'
        ];
    }

    function failedValidation (Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = new Response($validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }
    }
}
