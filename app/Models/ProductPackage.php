<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPackage extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
			'title'
		,   'slug'
		,   'summary'
		,   'content'
		,   'price'
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
	public function products(): HasManyThrough
	{
		return $this->hasManyThrough(Product::class, ProductPackageProduct::class, 'product_package_id', 'id', 'id', 'product_id');
	}

	public function reels(): HasMany
	{
		return $this->hasMany(Reel::class);
	}

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
	public function get_vigency()
	{
		$vigency = new \stdClass();
		if( now() >= $this->starts_at && now() <= $this->ends_at )
		{
			$vigency->type  = 'success';
			$vigency->text  = 'Vigente';
			$vigency->html  = '<i class="fa-regular fa-calendar-check me-1"></i> Vigente';
		}
		elseif( now() > $this->ends_at )
		{
			$vigency->type  = 'danger';
			$vigency->text  = 'Vencida';
			$vigency->html  = '<i class="fa-regular fa-calendar-xmark me-1"></i> Vencida';
		}
		elseif( now() < $this->starts_at )
		{
			$vigency->type  = 'info';
			$vigency->text  = 'Próxima';
			$vigency->html  = '<i class="fa-regular fa-calendar me-1"></i> Próxima';
		}

		return $vigency;
	}
	public function syncronize($product_list = [])
	{
		ProductPackageProduct::where('product_package_id', $this->id)->delete();
		foreach($product_list as $product)
		{
			ProductPackageProduct::create([
					'product_package_id'    => $this->id
				,   'product_id'            => $product
			]);
		}
	}

	public static function get_active_packages()
	{
		return self::where(function($query){
			$query->where('starts_at', '<=', now())
				->where('ends_at', '>=', now());
		})
			->orderBy('starts_at', 'ASC')
			->get();
	}

	public static function get_packages()
	{
		return self::where(function($query){
			$query->where('starts_at', '<=', now())
				->where('ends_at', '>=', now());
		})
			->orWhere(function($query){
				$query->where('starts_at', '>=', now())
					->where('ends_at', '>=', now());
			})
			->orderBy('starts_at', 'ASC')
			->get();
	}
}
