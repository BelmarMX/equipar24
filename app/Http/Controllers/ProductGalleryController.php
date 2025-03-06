<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductGalleryController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$this->can_view     = FALSE;
		$this->can_create   = FALSE;
		$this->can_edit     = FALSE;
		$this->can_delete   = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view     = $user->can('ver productos');
			$this->can_create   = $user->can('crear productos');
			$this->can_edit     = $user->can('editar productos');
			$this->can_delete   = $user->can('eliminar productos');
		}
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function gallery(Product $product)
    {
        return view('dashboard.products.edit-gallery', [
                'record'            => $product
            ,   'resource'          => 'products'
            ,   'gallery'           => new ProductGallery()
            ,   'gallery_resource'  => 'productGalleries'
        ]);
    }
    public function archived()
    {}

    public function datatable(Request $request, Product $product)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = ProductGallery::onlyTrashed();
	        $restore    = $this->can_delete;
        }
        else
        {
            $dt_of      = ProductGallery::query();
        }
        $dt_of          = $dt_of -> where('product_id', $product->id);

        return DataTables::of($dt_of)
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('productGalleries', 'title', FALSE, $restore, FALSE, $this->can_delete);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_FOLDER
            ,   TRUE
            ,   ImagesSettings::PRODUCT_RX_WIDTH
            ,   ImagesSettings::PRODUCT_RX_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = ProductGallery::create($validated);
        return redirect() -> route('productGalleries.gallery', $request->product_id) -> with(compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductGalleryRequest $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $productGallery)
    {
	    if( !$this->can_delete )
	    { abort(403); }

            parent::delete_image([
                $productGallery->image
            ,   $productGallery->image_rx
        ],  ImagesSettings::PRODUCT_FOLDER);
        $productGallery->delete();
        return redirect() -> back();
    }

    public function restore($product_gallery_id)
    {}
}
