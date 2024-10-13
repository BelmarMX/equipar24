<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormSubmitRequest;
use App\Http\Requests\UpdateFormSubmitRequest;
use App\Models\City;
use App\Models\FormSubmit;
use Illuminate\Http\Request;

class FormSubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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
    public function store(StoreFormSubmitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormSubmitRequest $request, FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormSubmit $formSubmit)
    {
        //
    }

    public function get_cities(Request $request)
    {
        return City::get_cities($request -> state_id);
    }
}
