<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormQuotationDetailRequest extends FormRequest
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
	            'cf-turnstile-response'     => 'Captcha'
            ,   "uuid"                      => "Usuario"
            ,   "state_id"                  => "ID Estado"
            ,   "city_id"                   => "ID Ciudad"
            ,   "name"                      => "Nombre(s)"
            ,   "email"                     => "Correo electrónico"
            ,   "phone"                     => "Teléfono"
            ,   "company"                   => "Empresa"
            ,   "comments"                  => "Comentarios"
            ,   'id'                        => "Producto"
            ,   'qty'                       => "Cantidad"
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
                'cf-turnstile-response'     => 'required'
            ,   "uuid"                      => 'nullable|uuid|exists:form_contacts,uuid'
            ,   "state_id"                  => "required|numeric|exists:states,id"
            ,   "city_id"                   => "required|numeric|exists:cities,id"
            ,   "name"                      => "required|string"
            ,   "email"                     => "required|email"
            ,   "phone"                     => "required|digits:10"
            ,   "company"                   => "nullable|string"
            ,   "comments"                  => "required|string"
            ,   'id'                        => "required"
            ,   'qty'                       => "required"
        ];
    }
}
