<?php

namespace App\Http\Requests;

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
            ,   "title"                     => "Título"
            ,   "video"                     => "Video"
            ,   "link"                      => "Enlace"
            ,   "link_title"                => "Título del enlace"
            ,   "link_summary"              => "Descripción del enlace"
            ,   "starts_at"                 => "Fecha de inicio"
            ,   "ends_at"                   => "Fecha de finalización"
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
                "product_id"                => "required|numeric|exists:products,id"
            ,   "promotion_id"              => "nullable|numeric|exists:promotions,id"
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:reels,slug"
            ,   "video"                     => "required|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm"
            ,   "link"                      => "required|url"
            ,   "link_title"                => "required|string"
            ,   "link_summary"              => "required|string"
            ,   "starts_at"                 => "required|date"
            ,   "ends_at"                   => "required|date"
        ];

        if( request() -> routeIs('promotions.edit') )
        {
            $rules["slug"]                  = "required|string|unique:reels,slug,".$this->id;
            $rules["video"]                 = "nullable|file|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/ogg,video/webm";
        }

        return $rules;
    }
}
