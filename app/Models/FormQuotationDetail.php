<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        ,   'product_model'
        ,   'product_brand'
        ,   'product_image'
        ,   'original_price'
        ,   'discount'
        ,   'total'
        ,   'notes'
    ];

    protected $appends  = [
            'human_created_at'
        ,   'created_dmy'
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

    /* ----------------------------------------------------------------------------------------------------------------
     * OTHER FEATURES
    ----------------------------------------------------------------------------------------------------------------- */
}
