<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
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
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.productCategories.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

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
	        $restore    = $this->can_delete;
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
                $actions            = parent::set_actions('productCategories', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
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
	    if( !$this->can_create )
	    { abort(403); }

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
	    if( !$this->can_create )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_CAT_FOLDER
            ,   TRUE
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

    public function reorder()
    {
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.productCategories.order', [
                'subtitle'  => 'Reordenar'
            ,   'records'   => ProductCategory::get_categories()
        ]);
    }

    public function update_order(Request $request)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        foreach($request->order AS $order)
        {
            $cat        = ProductCategory::find($order['id']);
            $cat->order = $order['position'];
            $cat->save();
        }

        return response()->json(['success'=>TRUE, 'message'=>'Orden actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $productCategory->delete();
        return redirect() -> route('productCategories.archived', ['deleted' => $productCategory->id]);
    }

    public function restore($product_category_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $productCategory = ProductCategory::onlyTrashed() -> find($product_category_id);
        $productCategory->restore();
        return redirect() -> route('productCategories.index', ['restored' => $productCategory->id]);
    }
}
