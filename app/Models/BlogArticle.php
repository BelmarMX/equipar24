<?php

namespace App\Models;

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

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function blog_category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
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
