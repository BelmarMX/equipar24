<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormContactRequest;
use App\Models\FormContact;
use Illuminate\Http\Request;

class FormContactController extends Controller
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
    public function store(FormContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormContact $formContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormContact $formContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormContactRequest $request, FormContact $formContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormContact $formContact)
    {
        //
    }

    public function restore($form_contact_id)
    {}
}
