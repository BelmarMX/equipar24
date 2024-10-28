<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.productCategories.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.productCategories.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = ProductCategory::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = ProductCategory::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('count_products', function($record) {
                return $record -> products -> count();
            })
            ->addColumn('count_subcategories', function($record) {
                return $record -> subcategories -> count();
            })
            ->addColumn('preview', function($record) {
                $show_thumbnail  = FALSE;
                return view('dashboard.partials.preview', compact('record', 'show_thumbnail')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('productCategories', 'title', FALSE, $restore);
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
        return view('dashboard.productCategories.create-edit', [
                'resource'      => 'productCategories'
            ,   'record'        => new ProductCategory()
            ,   'max'           => ProductCategory::max('id')+1
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_CAT_FOLDER
            ,   TRUE
            ,   ImagesSettings::PRODUCT_CAT_RX_WIDTH
            ,   ImagesSettings::PRODUCT_CAT_RX_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = ProductCategory::create($validated);
        return redirect() -> route('productCategories.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('dashboard.productCategories.create-edit', [
                'resource'      => 'productCategories'
            ,   'record'        => $productCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_CAT_FOLDER
            ,   FALSE
            ,   ImagesSettings::PRODUCT_CAT_RX_WIDTH
            ,   ImagesSettings::PRODUCT_CAT_RX_HEIGHT
            ,   $productCategory->image
            ,   NULL
            ,   $productCategory->image_rx
        );

        $validated['image']     = $stored -> full -> original   ?? $productCategory->image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $productCategory->image_rx;

        $productCategory -> update($validated);
        return redirect() -> route('productCategories.index', ['updated' => $productCategory->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect() -> route('productCategories.archived', ['deleted' => $productCategory->id]);
    }

    public function restore($product_category_id)
    {
        $productCategory = ProductCategory::onlyTrashed() -> find($product_category_id);
        $productCategory->restore();
        return redirect() -> route('productCategories.index', ['restored' => $productCategory->id]);
    }
}
