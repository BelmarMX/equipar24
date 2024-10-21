<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'title'
        ,   'slug'
        ,   'image'
        ,   'image_rx'
        ,   'description'
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
    public function project_galleries(): HasMany
    {
        return $this->hasMany(ProjectGallery::class);
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
            get: fn() => 'storage/'.ImagesSettings::PORTFOLIO_FOLDER.'/'
        );
    }
    protected function assetUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => asset('storage/'.ImagesSettings::PORTFOLIO_FOLDER).'/'
        );
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
