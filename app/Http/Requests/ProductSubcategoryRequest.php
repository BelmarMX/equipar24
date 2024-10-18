<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductSubcategoryRequest extends FormRequest
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
            ,   "title"                     => "Título"
            ,   "image"                     => "Portada"
            ,   "image_rx"                  => "Recorte de portada"
            ,   "is_featured"               => "Destacado"
            ,   "order"                     => "Orden"
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
            ,   "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:product_subcategories,slug"
            ,   "image"                     => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_SUBCAT_WIDTH.",height=".ImagesSettings::PRODUCT_SUBCAT_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_SUBCAT_RX_WIDTH.",height=".ImagesSettings::PRODUCT_SUBCAT_RX_HEIGHT
            ,   "is_featured"               => "required|boolean"
            ,   "order"                     => "required|numeric|min:0"
        ];

        if( request() -> routeIs('productSubcategories.update') )
        {
            $rules["slug"]                  = "required|string|unique:product_subcategories,slug,".$this->id;
        }

        return $rules;
    }
}
