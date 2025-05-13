<?php

namespace App\Http\Requests;

use App\Classes\EditorJS;
use App\Classes\ImagesSettings;
use Durlecode\EJSParser\Parser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class VacancyRequest extends FormRequest
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
				"title"                     => "Título"
			,   'slug'                      => 'Slug (Identificador Único de URL)'
			,   "summary"                   => "Resumen"
			,   "content"                   => "Contenido"
			,   "image"                     => "Portada"
			,   "image_rx"                  => "Recorte de portada"
			,   "starts_at"                 => "Fecha de inicio"
			,   "ends_at"                   => "Fecha de finalización"
		];
	}

	public function prepareforValidation()
	{
		$json_editor = EditorJS::correct_images_src($this->raw_editor);
		$this -> merge([
				'slug'      => Str::slug($this->title)
			,   'content'   => Parser::parse($json_editor)->toHtml()
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
				"title"                     => "required|string"
			,   "slug"                      => "required|string|unique:vacancies,slug"
			,   "summary"                   => "required|string"
			,   "content"                   => "required|string"
			,   "raw_editor"                => "required|json"
			,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::VACANCY_WIDTH.",min_height=".ImagesSettings::VACANCY_HEIGHT
			,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::VACANCY_RX_WIDTH.",min_height=".ImagesSettings::VACANCY_RX_HEIGHT
			,   "starts_at"                 => "required|date"
			,   "ends_at"                   => "required|date"
		];

		if( request() -> routeIs('vacancies.update') )
		{
			$rules["slug"]                  = "required|string|unique:vacancies,slug,".$this->route('vacancy.id');
			$rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::VACANCY_WIDTH.",min_height=".ImagesSettings::VACANCY_HEIGHT;
			$rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::VACANCY_RX_WIDTH.",min_height=".ImagesSettings::VACANCY_RX_HEIGHT;
		}

		return $rules;
	}
}
