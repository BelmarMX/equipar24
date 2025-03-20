<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ReelRequest extends FormRequest
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
            ,   "product_id"                => "ID del producto"
            ,   "product_package_id"        => "ID del paquete"
            ,   "title"                     => "Título"
            ,   'slug'                      => 'Slug (Identificador Único de URL)'
            ,   "video"                     => "Video"
            ,   "link"                      => "Enlace"
            ,   "link_title"                => "Título del enlace"
            ,   "link_summary"              => "Descripción del enlace"
            ,   "starts_at"                 => "Fecha de inicio"
            ,   "ends_at"                   => "Fecha de finalización"
            ,   "image"                     => "Poster"
            ,   "image_rx"                  => "Recorte de poster"
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
                "product_id"                => "nullable|numeric|exists:products,id"
            ,   "promotion_id"              => "nullable|numeric|exists:promotions,id"
            ,   "product_package_id"        => "nullable|numeric|exists:product_packages,id"
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:reels,slug"
            ,   "video"                     => "required|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm|max:32768"
            ,   "link"                      => "nullable|url"
            ,   "link_title"                => "nullable|string"
            ,   "link_summary"              => "nullable|string"
            ,   "starts_at"                 => "required|date"
            ,   "ends_at"                   => "required|date"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::REEL_WIDTH.",min_height=".ImagesSettings::REEL_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::REEL_WIDTH_RX.",height=".ImagesSettings::REEL_HEIGHT_RX
        ];

        if( request() -> routeIs('reels.update') )
        {
            $rules["slug"]                  = "required|string|unique:reels,slug,".$this->route('reel.id');
            $rules["video"]                 = "nullable|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm";
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::REEL_WIDTH.",min_height=".ImagesSettings::REEL_HEIGHT;
        }

        return $rules;
    }
}
