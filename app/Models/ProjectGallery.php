<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
        ,   'asset_folder'
        ,   'asset_url'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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
            get: fn() => 'storage/'.ImagesSettings::PORTFOLIO_IMG_FOLDER.'/'
        );
    }
    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::PORTFOLIO_IMG_FOLDER).'/'
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
