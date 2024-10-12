<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'form_contact_id'
        ,   'type'
        ,   'comment'
        ,   'notes'
        ,   'status'
        ,   'approved_by_user_id'
        ,   'rejected_by_user_id'
        ,   'approved_at'
        ,   'rejected_at'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function form_contact(): BelongsTo
    {
        return $this->belongsTo(FormContact::class);
    }

    public function form_quotation_details(): HasMany
    {
        return $this->hasMany(FormQuotationDetail::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
