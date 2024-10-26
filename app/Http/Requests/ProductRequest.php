<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
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
                "product_category_id"       => "ID Categoría"
            ,   "product_subcategory_id"    => "ID Subcategoría"
            ,   "product_brand_id"          => "ID Marca"
            ,   "title"                     => "Título"
            ,   'slug'                      => 'Slug (Identificador Único de URL)'
            ,   "model"                     => "Modelo"
            ,   "summary"                   => "Resumen"
            ,   "features"                  => "Características"
            ,   "description"               => "Descripción"
            ,   "price"                     => "Precio"
            ,   "is_featured"               => "Destacado"
            ,   "with_freight"              => "Con flete"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "data_sheet"                => "Hoja técnica"
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
                "product_category_id"       => "required|numeric|exists:product_categories,id"
            ,   "product_subcategory_id"    => "required|numeric|exists:product_subcategories,id"
            ,   "product_brand_id"          => "required|numeric|exists:product_brands,id"
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:products,slug"
            ,   "model"                     => "required|string"
            ,   "summary"                   => "required|string"
            ,   "features"                  => "required|string"
            ,   "description"               => "required|string"
            ,   "price"                     => "required|numeric|min:1"
            ,   "is_featured"               => "required|boolean"
            ,   "with_freight"              => "required|boolean"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_WIDTH.",height=".ImagesSettings::PRODUCT_HEIGHT
            ,   "image_rx"                  => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_RX_WIDTH.",height=".ImagesSettings::PRODUCT_RX_HEIGHT
            ,   "data_sheet"                => "required|file|mimes:pdf"
        ];

        if( request() -> routeIs('products.update') )
        {
            $rules["slug"]                  = "required|string|unique:products,slug,".$this->route('product.id');
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_WIDTH.",height=".ImagesSettings::PRODUCT_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_RX_WIDTH.",height=".ImagesSettings::PRODUCT_RX_HEIGHT;
            $rules["data_sheet"]            = "nullable|file|mimes:pdf";
        }

        return $rules;
    }
}
