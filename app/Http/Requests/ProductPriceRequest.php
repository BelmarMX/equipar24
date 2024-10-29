<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductPriceRequest extends FormRequest
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
                "user_id"       => "ID Usuario"
            ,   "old_prices"    => "Precios anteriores"
            ,   "new_prices"    => "Nuevos precios"
            ,   "is_deleted"    => "Archivo eliminado"
            ,   "is_blocked"    => "Archivo protegido"
        ];
    }

    public function prepareforValidation()
    {
        $this -> merge([
                'user_id'       => auth()->user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
                "user_id"                   => "required|numeric|exists:users,id"
            ,   "old_prices"                => "nullable|file|mimes:xlsx,xls,csv"
            ,   "new_prices"                => "nullable|file|mimes:xlsx,xls,csv"
            ,   "is_deleted"                => "nullable|boolean"
            ,   "id_blocked"                => "nullable|boolean"
        ];

        return $rules;
    }
}
