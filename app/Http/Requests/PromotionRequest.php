<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PromotionRequest extends FormRequest
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
            ,   "image"                     => "Anuncio"
            ,   "image_rx"                  => "Recorte de anuncio"
            ,   "image_mv"                  => "Anuncio para versión móvil"
            ,   "description"               => "Descripción"
            ,   "starts_at"                 => "Fecha de inicio"
            ,   "ends_at"                   => "Fecha de finalización"
            ,   "discount_type"             => "Tipo de descuento"
            ,   "Monto"                     => "Monto"
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
            ,   "slug"                      => "required|string|unique:promotions,slug"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH.",height=".ImagesSettings::PROMOS_HEIGHT
            ,   "image_rx"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH_MV.",height=".ImagesSettings::PROMOS_WIDTH_MV
            ,   "image_mv"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH_MV.",height=".ImagesSettings::PROMOS_HEIGHT_MV
            ,   "description"               => "required|string"
            ,   "starts_at"                 => "required|date"
            ,   "ends_at"                   => "required|date"
            ,   "discount_type"             => "required|string|in:percentage,fixed"
            ,   "Monto"                     => "required|numeric|min:1"
        ];

        if( request() -> routeIs('promotions.edit') )
        {
            $rules["slug"]                  = "required|string|unique:promotions,slug,".$this->id;
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH.",height=".ImagesSettings::PROMOS_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH_MV.",height=".ImagesSettings::PROMOS_WIDTH_MV;
            $rules["image_mv"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PROMOS_WIDTH_MV.",height=".ImagesSettings::PROMOS_WIDTH_MV;
        }

        return $rules;
    }
}
