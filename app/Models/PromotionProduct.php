<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
            'promotion_id'
        ,   'product_id'
        ,   'original_price'
        ,   'discount'
        ,   'total'
    ];

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function sync_prices_by_promotion(Promotion $promotion)
    {
        $set        = self::where('promotion_id', $promotion->id)->get();
        foreach($set AS $item)
        {
            $with_promotion         = $promotion->calculate(Product::find($item->product_id));
            $item->original_price   = $with_promotion->original_price;
            $item->discount         = $with_promotion->discount;
            $item->total            = $with_promotion->total;
            $item->save();
        }
    }

    public static function sync_prices_by_product(Product $product)
    {
        $set        = self::where('product_id', $product->id)->get();
        foreach($set AS $item)
        {
            $with_promotion         = Promotion::find($item->promotion_id)->calculate($product);
            $item->original_price   = $with_promotion->original_price;
            $item->discount         = $with_promotion->discount;
            $item->total            = $with_promotion->total;
            $item->save();
        }
    }
}
