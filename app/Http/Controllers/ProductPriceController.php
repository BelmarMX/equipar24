<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductPriceController extends Controller
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
    public function store(ProductSubcategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductSubcategoryRequest $request, ProductSubcategory $productSubcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubcategory $productSubcategory)
    {
        //
    }

    public function restore($product_subcategory_id)
    {}
}
