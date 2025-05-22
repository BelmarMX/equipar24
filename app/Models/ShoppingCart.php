<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShoppingCart extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
			'user_id'
		,   'session_id'
		,   'status'
	];
	protected $appends  = [
			'human_created_at'
		,   'created_dmy'
	];

	/* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
	public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(ShoppingCartItem::class);
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
