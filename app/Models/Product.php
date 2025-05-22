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
	        'sku'
		,   'product_category_id'
        ,   'product_subcategory_id'
        ,   'product_brand_id'
        ,   'title'
        ,   'slug'
        ,   'model'
        ,   'summary'
        ,   'features'
        ,   'description'
        ,   'price'
        ,   'in_stock'
        ,   'is_featured'
        ,   'with_freight'
	    ,   'availability'
	    ,   'quantity'
	    ,   'purchase_limit'
	    ,   'delivery_deadline'
        ,   'image'
        ,   'image_rx'
        ,   'data_sheet'
        ,   'raw_editor'
		,   'weight'
		,   'length'
		,   'width'
		,   'height'
		,   'is_fragile'
		,   'is_perishable'
		,   'requires_signature'
		,   'hazardous'
		,   'shipping_class'
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
        return $this->belongsToMany(Promotion::class, PromotionProduct::class, 'product_id', 'promotion_id', 'id', 'id');
    }

	public function packages(): BelongsToMany
	{
		return $this->belongsToMany(ProductPackage::class, ProductPackageProduct::class, 'product_id', 'product_package_id', 'id', 'id');
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
    public static function search($like_text, $brand = NULL)
    {
        $return     = self::query();
        $return->with(['product_brand', 'product_category', 'product_subcategory']);
        $return->where(function($query) use ($like_text) {
            $query->where('title', 'LIKE', '%'.$like_text.'%');
            $query->orWhere('model', 'LIKE', '%'.$like_text.'%');
        });

        if(!is_null($brand))
        {
            $return->whereHas('product_brand', function($query) use ($brand) {
                $query->where('title', $brand);
                $query->orWhere('slug', $brand);
            });
        }
        else
        {
            $return->orWhereHas('product_brand', function($query) use ($like_text) {
                $query->where('title', 'LIKE', '%'.$like_text.'%');
            });
        }

        $return->orderBy('is_featured', 'DESC');
        return $return->get();
    }

    public static function featured_products()
    {
        return self::where('is_featured', 1)
            ->orderBy('id', 'DESC')
            ->get();
    }

    public static function take_products($take = 4, $slug_brand = NULL, $slug_category = NULL, $slug_subcategory = NULL, $slug_product = NULL)
    {
        $return = self::query();
        $return->with(['product_brand', 'product_category', 'product_subcategory']);
        if( !is_null($slug_brand) )
        {
            $brand          = ProductBrand::where('slug', $slug_brand)->first();
            $return->where('product_brand_id', $brand->id);
        }
        if( !is_null($slug_subcategory) )
        {
            $subcategory    = ProductSubcategory::where('slug', $slug_subcategory)->first();
            $return->orWhere('product_subcategory_id', $subcategory->id);
        }
        $return->inRandomOrder();
        $return->orderBy('is_featured', 'DESC');
        if( !is_null($take) )
        {
            $return->take($take);
        }
        $return->get();

        if( (is_null($take) && $return->count() < $take) && !is_null($slug_category) )
        {
            $category       = ProductCategory::where('slug', $slug_category)->first();
            $return->orWhere('product_category_id', $category->id);
        }
        if( !is_null($take) )
        {
            $return->take($take);
        }
        return $return->get();
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

    public static function get_filtered($product_category_id, $product_subcategory_id)
    {
        return self::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where('product_category_id', $product_category_id)
            ->where('product_subcategory_id', $product_subcategory_id)
            ->orderBy('title', 'ASC')
            ->get();
    }

    public function get_higer_active_promo()
    {
        $high_promo     = NULL;
        $max_discount   = 0;
        $promotions     = $this->promotions()->where('starts_at', '<=', now())->where('ends_at', '>=', now())->get();
        foreach ($promotions as $promotion) {
            $promo_product = $promotion->promotion_products()->where('product_id', $this->id)->orderBy('discount', 'DESC')->first();
            if ($promo_product->discount > $max_discount)
            {
                $max_discount   = $promo_product->discount;
                $high_promo     = $promo_product;
            }
        }
        return $high_promo;
    }
}
