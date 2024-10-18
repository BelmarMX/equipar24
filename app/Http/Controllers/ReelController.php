<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReelRequest;
use App\Models\Reel;
use Illuminate\Http\Request;

class ReelController extends Controller
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
    public function store(ReelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reel $reel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reel $reel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReelRequest $request, Reel $reel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reel $reel)
    {
        //
    }

    public function restore($reel_id)
    {}
}
