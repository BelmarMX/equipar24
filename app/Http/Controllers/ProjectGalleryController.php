<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProjectGalleryRequest;
use App\Models\Project;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProjectGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function gallery(Project $project)
    {
        return view('dashboard.projects.edit-gallery', [
                'record'            => $project
            ,   'resource'          => 'projects'
            ,   'gallery'           => new ProjectGallery()
            ,   'gallery_resource'  => 'projectGalleries'
        ]);
    }

    public function archived()
    {}

    public function datatable(Request $request, Project $project)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = ProjectGallery::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = ProjectGallery::query();
        }
        $dt_of          = $dt_of -> where('project_id', $project->id);

        return DataTables::of($dt_of)
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('projectGalleries', 'title', TRUE, $restore, FALSE);
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectGalleryRequest $request)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PORTFOLIO_IMG_FOLDER
            ,   TRUE
            ,   ImagesSettings::PORTFOLIO_IMG_RX_WIDTH
            ,   ImagesSettings::PORTFOLIO_IMG_RX_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = ProjectGallery::create($validated);
        return redirect() -> route('projectGalleries.gallery', $request->project_id) -> with(compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectGallery $projectGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectGallery $projectGallery)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectGalleryRequest $request, ProjectGallery $projectGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectGallery $projectGallery)
    {
        parent::delete_image([
                $projectGallery->image
            ,   $projectGallery->image_rx
        ],  ImagesSettings::PORTFOLIO_IMG_FOLDER);
        $projectGallery->delete();
        return redirect() -> back();
    }

    public function restore($project_gallery_id)
    {}
}
