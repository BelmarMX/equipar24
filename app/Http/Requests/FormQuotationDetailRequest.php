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
                "form_submit_id"            => "ID Formulario de contacto"
            ,   "product_id"                => "ID del producto"
            ,   "promotion_id"              => "ID de la promoción"
            ,   "quantity"                  => "Cantidad"
            ,   "product_name"              => "Nombre del producto"
            ,   "original_price"            => "Precio original"
            ,   "discount"                  => "Descuento"
            ,   "total"                     => "Total"
            ,   "notes"                     => "Notas"
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
                "form_submit_id"            => "required|numeric|exists:form_submits,id"
            ,   "product_id"                => "required|numeric|exists:products,id"
            ,   "promotion_id"              => "nullable|numeric|exists:promotions,id"
            ,   "quantity"                  => "required|numeric|min:1"
            ,   "product_name"              => "required|string"
            ,   "original_price"            => "required|numeric"
            ,   "discount"                  => "required|numeric"
            ,   "total"                     => "required|numeric"
            ,   "notes"                     => "nullable|string"
        ];
    }
}
