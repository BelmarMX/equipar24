<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
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
			$this->can_view     = $user->can('ver proyectos');
			$this->can_create   = $user->can('crear proyectos');
			$this->can_edit     = $user->can('editar proyectos');
			$this->can_delete   = $user->can('eliminar proyectos');
		}
	}

    public function view()
    {
        return view('web.static.portafolio', array_merge(
                Navigation::get_static_data(['reels', 'related', 'articles'])
            ,   [
                'records' => Project::paginate(12)
            ]
        ));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.projects.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.projects.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Project::onlyTrashed();
            $restore    = $this->can_delete;
        }
        else
        {
            $dt_of      = Project::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('gallery_count', function($record){
                return $record->project_galleries->count();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('projects', 'title', TRUE, $restore, $this->can_edit, $this->can_delete, FALSE, ['route' => 'projectGalleries.gallery', 'tooltip' => 'Agregar imágenes a la galería']);
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

        return view('dashboard.projects.create-edit', [
                'resource'      => 'projects'
            ,   'record'        => new Project()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PORTFOLIO_FOLDER
            ,   TRUE
            ,   ImagesSettings::PORTFOLIO_RX_WIDTH
            ,   ImagesSettings::PORTFOLIO_RX_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = Project::create($validated);
        return redirect() -> route('projects.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug_project)
    {
        $project = Project::where('slug', $slug_project)->firstOrFail();
        return view('web.portfolio.portafolio-open', array_merge(
                Navigation::get_static_data(['banners', 'promos', 'reels', 'related', 'articles'])
            ,   [
                    'entry'     => $project
                ,   'gallery'   => $project->project_galleries
            ]
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.projects.create-edit', [
                'resource'      => 'projects'
            ,   'record'        => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PORTFOLIO_FOLDER
            ,   TRUE
            ,   ImagesSettings::PORTFOLIO_RX_WIDTH
            ,   ImagesSettings::PORTFOLIO_RX_HEIGHT
            ,   $project->image
            ,   NULL
            ,   $project->image_rx
        );

        $validated['image']     = $stored -> full -> original   ?? $project->image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $project->image_rx;

        $project -> update($validated);
        return redirect() -> route('projects.index', ['updated' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $project->delete();
        return redirect() -> route('projects.archived', ['deleted' => $project->id]);
    }

    public function restore($project_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $project = Project::onlyTrashed() -> find($project_id);
        $project->restore();
        return redirect() -> route('projects.index', ['restored' => $project -> id]);
    }
}
