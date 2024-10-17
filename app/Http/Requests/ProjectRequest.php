<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProjectRequest extends FormRequest
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
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "description"               => "Descripción"
        ];
    }

    public function prepareforValidation()
    {
        $this -> merge([
            'slug' => Str::slug($this -> title)
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
            ,   "slug"                      => "required|string|unique:projects,slug"
            ,   "image"                     => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PORTFOLIO_WIDTH.",height=".ImagesSettings::PORTFOLIO_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PORTFOLIO_RX_WIDTH.",height=".ImagesSettings::PORTFOLIO_RX_HEIGHT
            ,   "description"               => "required|string"
        ];

        if( request() -> routeIs('projects.edit') )
        {
            $rules["slug"]                  = "required|string|unique:projects,slug,".$this->id;
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PORTFOLIO_WIDTH.",height=".ImagesSettings::PORTFOLIO_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PORTFOLIO_RX_WIDTH.",height=".ImagesSettings::PORTFOLIO_RX_HEIGHT;
        }

        return $rules;
    }
}
