<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
                "title"         => "Título"
            ,   "building"      => "Edificio"
            ,   "street"        => "Calle"
            ,   "number"        => "Número"
            ,   "neighborhood"  => "Colonia"
            ,   "state_id"      => "Estado"
            ,   "city_id"       => "Ciudad"
            ,   "phone"         => "Teléfono"
            ,   "link"          => "Enlace corto"
            ,   "embed_code"    => "Código de incrustación"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
                "title"         => "required|string"
            ,   "building"      => "nullable|string"
            ,   "street"        => "required|string"
            ,   "number"        => "required|string"
            ,   "neighborhood"  => "required|string"
            ,   "state_id"      => "required|numeric|exists:states,id"
            ,   "city_id"       => "required|numeric|exists:cities,id"
            ,   "phone"         => "required|digits:10"
            ,   "link"          => "required|url"
            ,   "embed_code"    => "required|url"
        ];

        return $rules;
    }
}
