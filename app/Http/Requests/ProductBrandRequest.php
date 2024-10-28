<?php

namespace App\Http\Requests;

use App\Classes\ImagesSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductBrandRequest extends FormRequest
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
            ,   "image"                     => "Identificador"
            ,   "image_rx"                  => "Recorte de identificador"
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
                "title"                     => "required|string"
            ,   "slug"                      => "required|string|unique:product_brands,slug"
            ,   "image"                     => "required|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_BRAND_WIDTH.",height=".ImagesSettings::PRODUCT_BRAND_HEIGHT
            ,   "image_rx"                  => "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_BRAND_RX_WIDTH.",height=".ImagesSettings::PRODUCT_BRAND_RX_HEIGHT
            ,   "is_featured"               => "nullable|boolean"
            ,   "order"                     => "required|numeric|min:0"
        ];

        if( request() -> routeIs('productBrands.update') )
        {
            $rules["slug"]                  = "required|string|unique:product_brands,slug,".$this->route('productBrand.id');
            $rules["image"]                 = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_BRAND_WIDTH.",height=".ImagesSettings::PRODUCT_BRAND_HEIGHT;
            $rules["image_rx"]              = "nullable|image|mimes:jpeg,png,webp|max:".ImagesSettings::FILE_MAX_SIZE."|dimensions:width=".ImagesSettings::PRODUCT_BRAND_RX_WIDTH.",height=".ImagesSettings::PRODUCT_BRAND_RX_HEIGHT;
        }

        return $rules;
    }
}
