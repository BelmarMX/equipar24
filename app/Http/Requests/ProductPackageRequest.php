<?php

namespace App\Http\Requests;

use App\Classes\EditorJS;
use App\Classes\ImagesSettings;
use Durlecode\EJSParser\Parser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductPackageRequest extends FormRequest
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
            ,   "content"                   => "Content"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "price"                     => "Precio"
            ,   "starts_at"                 => "Fecha de inicio"
            ,   "ends_at"                   => "Fecha de finalización"
	        ,   'product_list'              => "Lista de productos"
        ];
    }

    public function prepareforValidation()
    {
	    $json_editor = EditorJS::correct_images_src($this->raw_editor);
        $this -> merge([
                'slug'          => Str::slug($this->title)
            ,   'content'       => Parser::parse($json_editor)->toHtml()
	        ,   'product_list'  => json_decode($this->product_list)
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
            ,   "slug"                      => "required|string|unique:products,slug"
	        ,   "summary"                   => "required|string"
	        ,   "content"                   => "required|string"
	        ,   "price"                     => "required|numeric|min:1"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::PRODUCT_PACKAGE_WIDTH.",min_height=".ImagesSettings::PRODUCT_PACKAGE_HEIGHT.",ratio:1"
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_PACKAGE_RX_WIDTH.",height=".ImagesSettings::PRODUCT_PACKAGE_RX_HEIGHT
            ,   "raw_editor"                => "required|json"
	        ,   "starts_at"                 => "required|date"
	        ,   "ends_at"                   => "required|date"
	        ,   "product_list"              => "required|array"
        ];

        if( request() -> routeIs('productPackages.update') )
        {
            $rules["slug"]                  = "required|string|unique:products,slug,".$this->route('product.id');
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:min_width=".ImagesSettings::PRODUCT_PACKAGE_WIDTH.",min_height=".ImagesSettings::PRODUCT_PACKAGE_HEIGHT.",ratio:1";
        }

        return $rules;
    }
}
