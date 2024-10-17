<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
                "promotion_id"              => "ID Promoción"
            ,   "title"                     => "Título"
            ,   "link"                      => "Enlace"
            ,   "image"                     => "Imagen"
            ,   "image_rx"                  => "Recorte de imagen"
            ,   "image_mv"                  => "Imagen para versión móvil"
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
                "promotion_id"              => "nullable|numeric|exists:promotions,id"
            ,   "title"                     => "required|string"
            ,   "link"                      => "nullable|url"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH.",height=".ImagesSettings::BANNER_HEIGHT
            ,   "image_rx"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH_MV.",height=".ImagesSettings::BANNER_HEIGHT_MV
            ,   "image_mv"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH_MV.",height=".ImagesSettings::BANNER_HEIGHT_MV
        ];

        if( request() -> routeIs('banners.edit') )
        {
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH.",height=".ImagesSettings::BANNER_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH_MV.",height=".ImagesSettings::BANNER_HEIGHT_MV;
            $rules["image_mv"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::BANNER_WIDTH_MV.",height=".ImagesSettings::BANNER_HEIGHT_MV;
        }

        return $rules;
    }
}
