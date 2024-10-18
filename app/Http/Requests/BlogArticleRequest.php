<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BlogArticleRequest extends FormRequest
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
                "blog_category_id"          => "ID Categoría"
            ,   "title"                     => "Título"
            ,   "summary"                   => "Enlace"
            ,   "content"                   => "Contenido"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "published_at"              => "Fecha de publicación"
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
                "blog_category_id"          => "required|numeric|exists:blog_categories,id"
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:blog_articles,slug"
            ,   "summary"                   => "required|string"
            ,   "content"                   => "required|string"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::ARTICLE_WIDTH.",height=".ImagesSettings::ARTICLE_HEIGHT
            ,   "image_rx"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::ARTICLE_RX_WIDTH.",height=".ImagesSettings::ARTICLE_RX_HEIGHT
            ,   "published_at"              => "required|date"
        ];

        if( request() -> routeIs('blogArticles.update') )
        {
            $rules["slug"]                  = "required|string|unique:blog_articles,slug,".$this->id;
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::ARTICLE_WIDTH.",height=".ImagesSettings::ARTICLE_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::ARTICLE_RX_WIDTH.",height=".ImagesSettings::ARTICLE_RX_HEIGHT;
        }

        return $rules;
    }
}
