<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormQuotationDetailRequest;
use App\Models\FormQuotationDetail;
use Illuminate\Http\Request;

class FormQuotatioDetailController extends Controller
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
    public function store(FormQuotationDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormQuotationDetail $formQuotationDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormQuotationDetail $formQuotationDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormQuotationDetailRequest $request, FormQuotationDetail $formQuotationDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormQuotationDetail $formQuotationDetail)
    {
        //
    }

    public function restore($form_quotation_detail_id)
    {}
}
