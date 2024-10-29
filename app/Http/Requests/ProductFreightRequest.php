<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFreightRequest extends FormRequest
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
            ,   "old_freights"  => "Fletes anteriores"
            ,   "new_freights"  => "Nuevos fletes"
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
            ,   "old_freights"              => "nullable|boolean"
            ,   "new_freights"              => "nullable|boolean"
        ];

        return $rules;
    }
}
