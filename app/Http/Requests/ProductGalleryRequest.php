<?php

namespace App\Http\Requests;

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
                "product_id"                => "required|numeric|exists:blog_categories,id"
            ,   "image"                     => "nullable|image|mimes:jpeg,png,webp"
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp"
            ,   "video"                     => "nullable|string"
            ,   "youtube_code"              => "nullable|numeric|min:0"
        ];
    }
}
