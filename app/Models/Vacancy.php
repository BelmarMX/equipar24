<?php

namespace App\Models;

use App\Classes\ImagesSettings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
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
	public function vacancy_requests(): \Illuminate\Database\Eloquent\Relations\HasMany
	{
		return $this->hasMany(VacancyRequest::class);
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
	protected function assetFolder(): Attribute
	{
		return Attribute::make(
			get: fn() => 'storage/'.ImagesSettings::VACANCY_FOLDER
		);
	}
	protected function assetUrl(): Attribute
	{
		return Attribute::make(
			get: fn() => asset('storage/'.ImagesSettings::VACANCY_FOLDER).'/'
		);
	}

	/* ----------------------------------------------------------------------------------------------------------------
	 * OTHER FEATURES
	----------------------------------------------------------------------------------------------------------------- */
	public static function get_vacancies()
	{
		return self::where('starts_at', '<=', now())
			->where('ends_at', '>=', now())
			->orderBy('ends_at', 'ASC')
			->get();
	}

	public static function get_latest($take)
	{
		return self::where('starts_at', '<=', now())
			->where('ends_at', '>=', now())
			->orderBy('ends_at', 'DESC')
			->take($take)
			->get();
	}

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
			$vigency->text  = 'Vencido';
			$vigency->html  = '<i class="fa-regular fa-calendar-xmark me-1"></i> Vencido';
		}
		elseif( now() < $this->starts_at )
		{
			$vigency->type  = 'info';
			$vigency->text  = 'Próximo';
			$vigency->html  = '<i class="fa-regular fa-calendar me-1"></i> Próximo';
		}

		return $vigency;
	}

	public static function has_active_vacancies()
	{
		return self::where('starts_at', '<=', now())
			->where('ends_at', '>=', now())
			->count() > 0;
	}
}
