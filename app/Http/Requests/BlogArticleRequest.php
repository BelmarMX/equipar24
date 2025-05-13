<?php

namespace App\Http\Requests;

use App\Classes\EditorJS;
use App\Classes\ImagesSettings;
use Durlecode\EJSParser\Parser;
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
            ,   'slug'                      => 'Slug (Identificador Único de URL)'
            ,   "summary"                   => "Resumen"
            ,   "content"                   => "Contenido"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "published_at"              => "Fecha de publicación"
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
                "blog_category_id"          => "required|numeric|exists:blog_categories,id"
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:blog_articles,slug"
            ,   "summary"                   => "required|string"
            ,   "content"                   => "required|string"
            ,   "raw_editor"                => "required|json"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::ARTICLE_WIDTH.",min_height=".ImagesSettings::ARTICLE_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::ARTICLE_RX_WIDTH.",min_height=".ImagesSettings::ARTICLE_RX_HEIGHT
            ,   "published_at"              => "required|date"
        ];

        if( request() -> routeIs('blogArticles.update') )
        {
            $rules["slug"]                  = "required|string|unique:blog_articles,slug,".$this->route('blogArticle.id');
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::ARTICLE_WIDTH.",min_height=".ImagesSettings::ARTICLE_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::ARTICLE_RX_WIDTH.",min_height=".ImagesSettings::ARTICLE_RX_HEIGHT;
        }

        return $rules;
    }
}
