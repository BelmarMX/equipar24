<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
                "state_id"                  => "ID Estado"
            ,   "city_id"                   => "ID Ciudad"
            ,   "name"                      => "Nombre(s)"
            ,   "email"                     => "Correo electrónico"
            ,   "phone"                     => "Teléfono"
            ,   "company"                   => "Empresa"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                "state_id"                  => "required|numeric|exists:states,id"
            ,   "city_id"                   => "required|numeric|exists:cities,id"
            ,   "name"                      => "required|string"
            ,   "email"                     => "required|string"
            ,   "phone"                     => "required|digits:10"
            ,   "company"                   => "required|string"
        ];
    }
}
