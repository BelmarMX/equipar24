<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCartItem extends Model
{
	protected $fillable = [
			'shopping_cart_id'
		,   'product_id'
		,   'quantity'
		,   'price'
	];
	protected $appends  = [
			'human_created_at'
		,   'created_dmy'
	];

	/* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
	public function shopping_cart(): BelongsTo
	{
		return $this->belongsTo(ShoppingCart::class);
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
