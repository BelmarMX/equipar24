<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'uuid'
        ,   'state_id'
        ,   'city_id'
        ,   'name'
        ,   'email'
        ,   'phone'
        ,   'company'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function form_submits(): HasMany
    {
        return $this->hasMany(FormSubmit::class);
    }

    public function form_quotation_details(): HasManyThrough
    {
        return $this->hasManyThrough(FormQuotationDetail::class, FormSubmit::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
