<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormVacancyRequest extends FormRequest
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
			,   "vacancy_id"                => "Vacante"
			,   "name"                      => "Nombre(s)"
			,   "email"                     => "Correo electrónico"
			,   "phone"                     => "Teléfono"
			,   "file"                      => "Currículum"
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
			,   "vacancy_id"                => 'required|numeric|exists:vacancies,id'
			,   "name"                      => "required|string"
			,   "email"                     => "required|email"
			,   "phone"                     => "required|digits:10"
			,   "file"                      => "required|file|mimes:pdf,doc,docx"
		];
	}
}
