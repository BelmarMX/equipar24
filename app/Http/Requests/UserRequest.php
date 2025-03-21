<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserRequest extends FormRequest
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
                "name"                      => "Nombre del usuario"
            ,   "email"                     => "Email del usuario"
            ,   "password"                  => "Contraseña"
            ,   'password_confirmation'     => 'Confirmación de contraseña'
            ,   "role"                      => "Rol (Permisos)"
            ,   "original_role"             => "Rol anterior"
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
                "name"                      => "required|string"
            ,   "email"                     => "required|email|unique:users,id"
            ,   "password"                  => "required|string|confirmed|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/"
            ,   "role"                      => "required|string"
	        ,   "original_role"             => "nullable|string"
        ];

        if( request() -> routeIs('users.update') )
        {
            $rules["password"]              = "nullable|string|confirmed|min:8";
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "password.regex"                => "La contraseña debe contener al menos una letra, un número y un carácter especial (@, $, !, %, *, ?, &)"
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data               = parent::validated($key, $default);
	    if( !empty($data['password']) )
		{
			$data["password"]   = Hash::make($data["password"]);
		}
		else{
			unset($data["password"]);
		}
        return $data;
    }
}
