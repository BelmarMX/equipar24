<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSubmitRequest extends FormRequest
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
                "g-recaptcha-response"      => "reCaptcha"
            ,   "form_contact_id"           => "Información del contacto"
            ,   "type"                      => "Tipo de formulario"
            ,   "comment"                   => "Comentarios"
            ,   "notes"                     => "Notas"
            ,   "status"                    => "Estatus"
            ,   "approved_by_user_id"       => "Aprobador por"
            ,   "rejected_by_user_id"       => "Rechazado por"
            ,   "approved_at"               => "Fecha de aprobación"
            ,   "rejected_at"               => "Fecha de rechazo"
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
                "g-recaptcha-response"      => "required|string"
            ,   "form_contact_id"           => "required|numeric|exists:form_contacts,id"
            ,   "type"                      => "required|string|in:contact,quotation"
            ,   "comment"                   => "required|string"
            ,   "notes"                     => "nullable|string"
            ,   "status"                    => "required|string|in:pending,approved,rejected"
            ,   "approved_by_user_id"       => "nullable|numeric|exists:products,id"
            ,   "rejected_by_user_id"       => "nullable|numeric|exists:promotions,id"
            ,   "approved_at"               => "nullable|date"
            ,   "rejected_at"               => "nullable|date"
        ];
    }
}
