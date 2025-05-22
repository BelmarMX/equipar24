<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
			'order_id'
		,   'shipping_address'
		,   'carrier'
		,   'tracking_number'
		,   'shipped_at'
		,   'delivered_at'
		,   'canceled_at'
		,   'status'
		,   'notes'
	];
	protected $appends  = [
			'human_created_at'
		,   'created_dmy'
	];

	/* ----------------------------------------------------------------------------------------------------------------
     * RELATIONSHIP
    ----------------------------------------------------------------------------------------------------------------- */
	public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
	{
		return $this->belongsTo(Order::class);
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
