<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'project_id'
        ,   'title'
        ,   'image'
        ,   'image_rx'
        ,   'video'
        ,   'youtube_code'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
