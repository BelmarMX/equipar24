<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'state_id'
        ,   'code'
        ,   'name'
        ,   'variant'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function form_contacts(): HasMany
    {
        return $this->hasMany(FormContact::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
    public static function get_cities($state_id)
    {
        return self::select(['id', 'name'])
            ->where('state_id', $state_id)
            ->orderBy('name', 'ASC')
            ->get();
    }
}
