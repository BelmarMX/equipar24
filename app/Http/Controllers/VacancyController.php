<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\FormVacancyRequest;
use App\Http\Requests\VacancyRequest;
use App\Models\Vacancy;
use App\Mail\VacancyMail;
use App\Models\VacancyRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class VacancyController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$this->can_view     = FALSE;
		$this->can_create   = FALSE;
		$this->can_edit     = FALSE;
		$this->can_delete   = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view     = $user->can('ver blog');
			$this->can_create   = $user->can('crear blog');
			$this->can_edit     = $user->can('editar blog');
			$this->can_delete   = $user->can('eliminar blog');
		}
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		if( !$this->can_view )
		{ abort(403); }

		return view('dashboard.vacancies.index', [
			'subtitle' => 'Registros activos'
		]);
	}

	public function archived()
	{
		if( !$this->can_delete )
		{ abort(403); }

		return view('dashboard.vacancies.index', [
				'subtitle'      => 'Registros eliminados'
			,   'with_trashed'  => TRUE
		]);
	}

	public function datatable(Request $request)
	{
		$restore        = FALSE;
		if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
		{
			$dt_of      = Vacancy::onlyTrashed();
			$restore    = $this->can_delete;
		}
		else
		{
			$dt_of      = Vacancy::query();
		}

		return DataTables::of($dt_of)
			->addColumn('preview', function($record) {
				return view('dashboard.partials.preview', compact('record')) -> render();
			})
			->addColumn('action', function ($record) use ($restore) {
				$actions            = parent::set_actions('vacancies', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
				return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
			})
			->rawColumns(['preview', 'action'])
			->toJson();
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		if( !$this->can_create )
		{ abort(403); }

		return view('dashboard.vacancies.create-edit', [
				'resource'      => 'vacancies'
			,   'record'        => new Vacancy()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(VacancyRequest $request)
	{
		if( !$this->can_create )
		{ abort(403); }

		$validated              = $request -> validated();
		$stored                 = parent::store_all_images_from_request(
			$request -> file('image')
			,   NULL
			,   $validated['title']
			,   ImagesSettings::VACANCY_FOLDER
			,   TRUE
			,   ImagesSettings::VACANCY_RX_WIDTH
			,   ImagesSettings::VACANCY_RX_HEIGHT
		);

		$validated['image']     = $stored -> full -> original;
		$validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

		$created                = Vacancy::create($validated);
		return redirect() -> route('vacancies.index', compact('created'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Vacancy $vacancy)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Vacancy $vacancy)
	{
		if( !$this->can_edit )
		{ abort(403); }

		return view('dashboard.vacancies.create-edit', [
				'resource'      => 'vacancies'
			,   'record'        => $vacancy
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(VacancyRequest $request, Vacancy $vacancy)
	{
		if( !$this->can_edit )
		{ abort(403); }

		$validated              = $request -> validated();
		$stored                 = parent::store_all_images_from_request(
				$request -> file('image')
			,   NULL
			,   $validated['title']
			,   ImagesSettings::VACANCY_FOLDER
			,   TRUE
			,   ImagesSettings::VACANCY_RX_WIDTH
			,   ImagesSettings::VACANCY_RX_HEIGHT
			,   $vacancy -> image
			,   NULL
			,   $vacancy -> image_rx
		);

		$validated['image']     = $stored->full->original   ?? $vacancy->image;
		$validated['image_rx']  = $stored->full->thumbnail  ?? $vacancy->image_rx;

		$vacancy -> update($validated);
		return redirect() -> route('vacancies.index', ['updated' => $vacancy->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Vacancy $vacancy)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$vacancy->delete();
		return redirect() -> route('vacancies.archived', ['deleted' => $vacancy->id]);
	}

	public function restore($vacancy_id)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$vacancy = Vacancy::onlyTrashed() -> find($vacancy_id);
		$vacancy->restore();
		return redirect() -> route('vacancies.index', ['restored' => $vacancy->id]);
	}

	public function vacancies_list()
	{
		return view('web.blog.vacancies', array_merge(
				Navigation::get_static_data(['reels', 'related', 'vacancies'])
				,   [
					'vacancies' => Vacancy::where('starts_at', '<=', now())->where('ends_at', '>=', now())->orderBy('ends_at')->paginate(12)
				]
			)
		);
	}

	public function show_vacancy($slug_vacancy)
	{
		$vacancy                        = Vacancy::where('slug', $slug_vacancy)->firstOrFail();

		return view('web.blog.vacancy-open', array_merge(
				Navigation::get_static_data(['banners', 'reels', 'related', 'vacancies'])
				,   [
						'vacancy'       => $vacancy
					,   'latest'        => Vacancy::get_latest(4)
				]
			)
		);
	}

	public function send(FormVacancyRequest $request)
	{
		$validated              = $request->validated();
		$verify                 = parent::verify_turnstile($validated['cf-turnstile-response']);
		if( !$verify->success )
		{
			abort(500, 'Todo indica que eres un robot.');
		}

		$original_file      = $validated['file'];
		$validated['file']  = parent::store_file($request->file('file'), $validated['name'], ImagesSettings::VACANCY_FOLDER.'curriculum');
		VacancyRequests::create($validated);

		// Enviar email
		Mail::to(env('MAIL_RRHH_ADDRESS'), env('Recursos Humanos Equipar'))
			->send(new VacancyMail($validated, $original_file));

		return redirect() -> route('gracias');
	}
}
