<?php

namespace App\Http\Requests\ContractorCompany;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nit' => 'required|string|max:100',
            'business_name' => 'required|string|max:500',
            'address' => 'required|string|max:500',
            'country_id' => 'required|integer',
            'tags' => 'nullable|string',
            'responsable' => 'required|string|max:500',
            'email' => 'required|email|max:1000',
            'phone' => 'required|string|max:500'
        ];
    }
}
