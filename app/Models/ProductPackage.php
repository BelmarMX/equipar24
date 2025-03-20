<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPackage extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
			'title'
		,   'slug'
		,   'summary'
		,   'content'
		,   'image'
		,   'image_rx'
		,   'raw_editor'
		,   'starts_at'
		,   'ends_at'
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

	/* ----------------------------------------------------------------------------------------------------------------
	 * MUTATORS AND ACCESSORS
	----------------------------------------------------------------------------------------------------------------- */
	protected function assetFolder(): Attribute
	{
		return Attribute::make(
			get: fn() => 'storage/'.ImagesSettings::PRODUCT_PACKAGE_FOLDER
		);
	}
	protected function assetUrl(): Attribute
	{
		return Attribute::make(
			get: fn() => asset('storage/'.ImagesSettings::PRODUCT_PACKAGE_FOLDER).'/'
		);
	}
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
