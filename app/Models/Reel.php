<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'promotion_id'
        ,   'product_id'
        ,   'title'
        ,   'slug'
        ,   'video'
        ,   'link'
        ,   'link_title'
        ,   'link_summary'
        ,   'starts_at'
        ,   'ends_at'
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
    protected function assetFolder(): Attribute
    {
        return Attribute::make(
            get: fn() => 'storage/'.ImagesSettings::REEL_FOLDER.'/'
        );
    }
    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::REEL_FOLDER).'/'
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function get_reels()
    {
        return self::where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->orderBy('starts_at', 'ASC')
            ->get();
    }
}
