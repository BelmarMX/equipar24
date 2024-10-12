<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'title'
        ,   'slug'
        ,   'image'
        ,   'image_rx'
        ,   'is_featured'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function products_categories(): ProductCategory
    {
        return $this->products()->product_category();
    }

    public function products_subcategories(): ProductSubcategory
    {
        return $this->products()->product_subcategory();
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
