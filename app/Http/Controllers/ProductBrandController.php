<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductBrandRequest;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.productBrands.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.productBrands.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = ProductBrand::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = ProductBrand::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('count_products', function($record) {
                return $record -> products -> count();
            })
            ->addColumn('preview', function($record) {
                $show_thumbnail  = TRUE;
                return view('dashboard.partials.preview', compact('record', 'show_thumbnail')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('productBrands', 'title', FALSE, $restore);
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
        return view('dashboard.productBrands.create-edit', [
                'resource'      => 'productBrands'
            ,   'record'        => new ProductBrand()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductBrandRequest $request)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_BRAND_FOLDER
            ,   FALSE
            ,   ImagesSettings::PRODUCT_BRAND_WIDTH
            ,   ImagesSettings::PRODUCT_BRAND_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = ProductBrand::create($validated);
        return redirect() -> route('productBrands.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductBrand $productBrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductBrand $productBrand)
    {
        return view('dashboard.productBrands.create-edit', [
                'resource'      => 'productBrands'
            ,   'record'        => $productBrand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductBrandRequest $request, ProductBrand $productBrand)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_BRAND_FOLDER
            ,   FALSE
            ,   ImagesSettings::PRODUCT_BRAND_WIDTH
            ,   ImagesSettings::PRODUCT_BRAND_HEIGHT
            ,   $productBrand->image
            ,   NULL
            ,   $productBrand->image_rx
        );

        $validated['image']     = $stored -> full -> original   ?? $productBrand->image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $productBrand->image_rx;

        $productBrand -> update($validated);
        return redirect() -> route('productBrands.index', ['updated' => $productBrand->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductBrand $productBrand)
    {
        $productBrand->delete();
        return redirect() -> route('productBrands.archived', ['deleted' => $productBrand->id]);
    }

    public function restore($product_brand_id)
    {
        $productBrand = ProductBrand::onlyTrashed() -> find($product_brand_id);
        $productBrand->restore();
        return redirect() -> route('productBrands.index', ['restored' => $productBrand->id]);
    }
}
