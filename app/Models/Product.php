<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'product_category_id'
        ,   'product_subcategory_id'
        ,   'product_brand_id'
        ,   'title'
        ,   'slug'
        ,   'model'
        ,   'summary'
        ,   'features'
        ,   'description'
        ,   'price'
        ,   'is_featured'
        ,   'with_freight'
        ,   'image'
        ,   'image_rx'
        ,   'data_sheet'
    ];

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
        ,   'asset_folder'
        ,   'asset_url'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function product_category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function product_subcategory(): BelongsTo
    {
        return $this->belongsTo(ProductSubcategory::class);
    }

    public function product_brand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function product_galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, PromotionProduct::class);
    }

    public function reels(): HasMany
    {
        return $this->hasMany(Reel::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * MUTATORS AND ACCESSORS
    ----------------------------------------------------------------------------------------------------------------- */
    protected function humanCreatedAt(): Attribute
    {
        $human = !empty($this->created_at) ? ucfirst($this->created_at->diffForHumans()) : NULL;
        return Attribute::make(
            get: fn() => $human
        );
    }
    protected function createdDmy(): Attribute
    {
        return Attribute::make(
            get: fn() => Carbon::parse($this->created_at)->format('d/m/Y H:i')
        );
    }
    protected function assetFolder(): Attribute
    {
        return Attribute::make(
            get: fn() => 'storage/'.ImagesSettings::PRODUCT_FOLDER
        );
    }
    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::PRODUCT_FOLDER).'/'
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function featured_products()
    {
        return self::where('is_featured', 1)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function take_products($take = 4)
    {
        return self::orderBy('is_featured', 'DESC')
            ->orderBy('id', 'DESC')
            ->take($take)
            ->get();
    }

    public static function get_related($product_brand_id, $product_category_id, $product_subcategory_id, $take = 4)
    {
        return self::where('product_brand_id', $product_brand_id)
            ->orWhere('product_category_id', $product_category_id)
            ->orWhere('product_subcategory_id', $product_subcategory_id)
            ->take($take)
            ->inRandomOrder()
            ->get();
    }
}
