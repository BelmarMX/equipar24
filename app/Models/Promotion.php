<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'title'
        ,   'slug'
        ,   'image'
        ,   'image_rx'
        ,   'image_mv'
        ,   'description'
        ,   'starts_at'
        ,   'ends_at'
        ,   'discount_type'
        ,   'amount'
    ];

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
        ,   'asset_folder'
        ,   'asset_url'
        ,   'days_left'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function banner(): HasOne
    {
        return $this->hasOne(Banner::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, PromotionProduct::class, 'promotion_id', 'id', 'id', 'product_id');
    }

    public function reels(): HasMany
    {
        return $this->hasMany(Reel::class);
    }

    public function promotion_products()
    {
        return $this->hasMany(PromotionProduct::class, 'promotion_id');
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
            get: fn() => 'storage/'.ImagesSettings::PROMOS_FOLDER
        );
    }

    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::PROMOS_FOLDER).'/'
        );
    }

    protected function daysLeft(): Attribute
    {
        $human = !empty($this->ends_at) ? ucfirst(Carbon::createFromDate($this->ends_at)->diffForHumans()) : NULL;
        return Attribute::make(
            get: fn() => $human
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function get_active_promotions()
    {
        return self::where(function($query){
            $query->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now());
        })
            ->orderBy('starts_at', 'ASC')
            ->get();
    }

    public static function get_promotions()
    {
        return self::where(function($query){
                $query->where('starts_at', '<=', now())
                    ->where('ends_at', '>=', now());
            })
            ->orWhere(function($query){
                $query->where('starts_at', '>=', now())
                    ->where('ends_at', '>=', now());
            })
            ->orderBy('starts_at', 'ASC')
            ->get();
    }

    public function get_vigency()
    {
        $vigency = new \stdClass();
        if( now() >= $this->starts_at && now() <= $this->ends_at )
        {
            $vigency->type  = 'success';
            $vigency->text  = 'Vigente';
            $vigency->html  = '<i class="fa-regular fa-calendar-check me-1"></i> Vigente';
        }
        elseif( now() > $this->ends_at )
        {
            $vigency->type  = 'danger';
            $vigency->text  = 'Vencida';
            $vigency->html  = '<i class="fa-regular fa-calendar-xmark me-1"></i> Vencida';
        }
        elseif( now() < $this->starts_at )
        {
            $vigency->type  = 'info';
            $vigency->text  = 'Próxima';
            $vigency->html  = '<i class="fa-regular fa-calendar me-1"></i> Próxima';
        }

        return $vigency;
    }

    public function has_product($product_id)
    {
        return $this->products()->where('product_id', $product_id)->first();
    }

    public function calculate($product)
    {
        if( $this->discount_type == 'fixed' )
        {
            $total = $product->price - $this->amount;
        }
        else
        {
            $total = $product->price - ($this->amount * $product->price) / 100;
        }

        $return = new \stdClass();
        $return->original_price = $product->price;
        $return->discount       = $product->price - $total;
        $return->total          = $total;

         return $return;
    }
}
