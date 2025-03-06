<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductFreightRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductFreightController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$user               = Auth()->user();
		$this->can_view     = $user->can('ver fletes');
		$this->can_create   = $user->can('crear fletes');
		$this->can_edit     = $user->can('editar fletes');
		$this->can_delete   = $user->can('eliminar fletes');
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.products.freight.index', [
                'brands'        => ProductBrand::get_brands()
            ,   'categories'    => ProductCategory::get_categories()
        ]);
    }

    public function archived()
    {}

    public function datatable(Request $request)
    {
        $products = Product::query();
        if( !empty($request -> product_category_id) )
        {
            $products -> where('product_category_id', $request -> product_category_id);
        }
        if( !empty($request -> product_category_id) )
        {
            $products -> where('product_category_id', $request -> product_category_id);
        }
        if( !empty($request -> product_brand_id) )
        {
            $products -> where('product_brand_id', $request -> product_brand_id);
        }
        if( !empty($request -> is_featured) )
        {
            $products -> where('is_featured', $request -> is_featured);
        }
        if( !empty($request -> with_freight) )
        {
            $products -> where('with_freight', $request -> with_freight);
        }

        return DataTables::of($products)
            ->addColumn('category', function($record) {
                return $record -> product_category -> title ?? '🚫 Eliminada';
            })
            ->addColumn('subcategory', function($record) {
                return $record -> product_subcategory -> title ?? '🚫 Eliminada';
            })
            ->addColumn('brand', function($record) {
                return $record -> product_brand -> title ?? '🚫 Eliminada';
            })
            ->addColumn('old_freight', function($record){
                $prefix     = 'old_freight';
                $readonly   = TRUE;
                return view('dashboard.products.freight.input', compact('prefix', 'readonly', 'record')) -> render();
            })
            ->addColumn('new_freight', function($record){
                $prefix     = 'new_freight';
                $readonly   = FALSE;
                return view('dashboard.products.freight.input', compact('prefix', 'readonly', 'record')) -> render();
            })
            ->rawColumns(['old_freight', 'new_freight'])
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
    public function store(ProductFreightRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function restore($product_price_id)
    {}

    public function update_massive(Request $request)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $counter = 0;
        foreach($request->dataset AS $data)
        {
            $product = Product::find($data['id']);
            if( $product )
            {
                $product -> update(['with_freight' => $data['with_freight']]);
                $counter++;
            }
        }
        return response() -> json([
                'success'   => TRUE
            ,   'message'   => "Se actualizaron {$counter} productos correctamente."
        ]);
    }
}
