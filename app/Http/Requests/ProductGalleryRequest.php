<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;

class ProductGalleryRequest extends FormRequest
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
                "product_id"                => "ID Producto"
            ,   "title"                     => "Título"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "video"                     => "Video"
            ,   "youtube_code"              => "Código de YouTube"
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
                "product_id"                => "required|numeric|exists:products,id"
            ,   "title"                     => "required|string"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::PRODUCT_WIDTH.",min_height=".ImagesSettings::PRODUCT_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_RX_WIDTH.",height=".ImagesSettings::PRODUCT_RX_HEIGHT
            ,   "video"                     => "nullable|string"
            ,   "youtube_code"              => "nullable|numeric|min:0"
        ];
    }
}
