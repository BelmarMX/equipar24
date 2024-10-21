<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'blog_category_id'
        ,   'title'
        ,   'slug'
        ,   'summary'
        ,   'content'
        ,   'image'
        ,   'image_rx'
        ,   'published_at'
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
    public function blog_category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
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
            get: fn() => 'storage/'.ImagesSettings::ARTICLE_FOLDER.'/'
        );
    }
    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::ARTICLE_FOLDER).'/'
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function get_articles()
    {
        return self::where('published_at', '<=', now())
            ->orderBy('published_at', 'DESC')
            ->get();
    }
}
