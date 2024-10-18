<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectGalleryRequest;
use App\Models\ProjectGallery;
use Illuminate\Http\Request;

class ProjectGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function archived()
    {}

    public function datatable(Request $request)
    {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectGalleryRequest $request)
    {
        //
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
        //
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
        //
    }

    public function restore($project_gallery_id)
    {}
}
