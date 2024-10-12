<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormQuotationDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
            'form_submit_id'
        ,   'product_id'
        ,   'promotion_id'
        ,   'uuid'
        ,   'quantity'
        ,   'product_name'
        ,   'original_price'
        ,   'discount'
        ,   'total'
        ,   'notes'
    ];

    /* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
    public function form_submit(): BelongsTo
    {
        return $this->belongsTo(FormSubmit::class);
    }

    public function form_contact(): FormContact
    {
        return $this->form_submit()->form_contact();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
