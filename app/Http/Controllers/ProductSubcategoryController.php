<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductSubcategoryRequest;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductSubcategoryController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$user               = Auth()->user();
		$this->can_view     = $user->can('ver productos');
		$this->can_create   = $user->can('crear productos');
		$this->can_edit     = $user->can('editar productos');
		$this->can_delete   = $user->can('eliminar productos');
	}

    /**
     * Display a listing of the resource.
     */
    public function index($filter_type = NULL, $filter_id = NULL)
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.productSubcategories.index', [
                'subtitle' => 'Registros activos'
            ,   'filter_type'   => $filter_type
            ,   'filter_id'     => $filter_id
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.productSubcategories.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request, $filter_type = NULL, $filter_id = NULL)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = ProductSubcategory::onlyTrashed();
	        $restore    = $this->can_delete;
        }
        else
        {
            $dt_of      = ProductSubcategory::query();
        }

        if( !empty($filter_type) )
        {
            switch($filter_type)
            {
                case 'category':        $dt_of->where('product_category_id', $filter_id);       break;
            }
        }

        return DataTables::of($dt_of)
            ->addColumn('category', function($record) {
                return $record -> product_category -> title ?? '🚫 Eliminada';
            })
            ->addColumn('count_products', function($record) {
                return $record -> products -> count();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('productSubcategories', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

        return view('dashboard.productSubcategories.create-edit', [
                'resource'      => 'productSubcategories'
            ,   'categories'    => ProductCategory::get_categories()
            ,   'record'        => new ProductSubcategory()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductSubcategoryRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

        $validated              = $request -> validated();
        $created                = ProductSubcategory::create($validated);
        return redirect() -> route('productSubcategories.index', compact('created'));
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
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.productSubcategories.create-edit', [
                'resource'      => 'productSubcategories'
            ,   'categories'    => ProductCategory::get_categories()
            ,   'record'        => $productSubcategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductSubcategoryRequest $request, ProductSubcategory $productSubcategory)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $productSubcategory -> update($validated);
        return redirect() -> route('productSubcategories.index', ['updated' => $productSubcategory->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSubcategory $productSubcategory)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $productSubcategory->delete();
        return redirect() -> route('productSubcategories.archived', ['deleted' => $productSubcategory->id]);
    }

    public function restore($product_category_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $productSubcategory = ProductSubcategory::onlyTrashed() -> find($product_category_id);
        $productSubcategory->restore();
        return redirect() -> route('productSubcategories.index', ['restored' => $productSubcategory->id]);
    }
}
