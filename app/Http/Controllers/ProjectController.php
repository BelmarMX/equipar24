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
        return view('dashboard.projects.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
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
            $restore    = TRUE;
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
                $actions            = parent::set_actions('projects', 'title', TRUE, $restore, TRUE, TRUE, FALSE, ['route' => 'projectGalleries.gallery', 'tooltip' => 'Agregar imágenes a la galería']);
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
        $project->delete();
        return redirect() -> route('projects.archived', ['deleted' => $project->id]);
    }

    public function restore($project_id)
    {
        $project = Project::onlyTrashed() -> find($project_id);
        $project->restore();
        return redirect() -> route('projects.index', ['restored' => $project -> id]);
    }
}
