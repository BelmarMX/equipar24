<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class RoleRequest extends FormRequest
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
                "name"                      => "Nombre del rol"
            ,   "permissions"               => "Permisos"
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
                "name"                      => "required|string|unique:roles,name,".$this->route('role')->id
            ,   "permissions"               => "nullable|array"
        ];

        return $rules;
    }

	public function validated($key = null, $default = null)
	{
		$data                   = parent::validated($key, $default);
		$data["name"]           = mb_strtolower($data['name']);
		$data["permissions"]    = array_values($data["permissions"]);
		return $data;
	}
}
