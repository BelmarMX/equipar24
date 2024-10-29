<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ProductPriceRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;
use Yajra\DataTables\DataTables;

class ProductPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.products.prices.index', [
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
            ->addColumn('old_price', function($record){
                $prefix     = 'old_price';
                $readonly   = TRUE;
                return view('dashboard.products.prices.input', compact('prefix', 'readonly', 'record')) -> render();
            })
            ->addColumn('new_price', function($record){
                $prefix     = 'new_price';
                $readonly   = FALSE;
                return view('dashboard.products.prices.input', compact('prefix', 'readonly', 'record')) -> render();
            })
            ->rawColumns(['old_price', 'new_price'])
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
    public function store(ProductPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductPrice $productPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductPrice $productPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductPriceRequest $request, ProductPrice $productPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductPrice $productPrice)
    {
        //
    }

    public function restore($product_price_id)
    {}

    public function generate_massive_file(Request $request)
    {
        $record = Product::query();
        if( !empty($request -> product_category_id) )
        {
            $record -> where('product_category_id', $request -> product_category_id);
        }
        if( !empty($request -> product_category_id) )
        {
            $record -> where('product_category_id', $request -> product_category_id);
        }
        if( !empty($request -> product_brand_id) )
        {
            $record -> where('product_brand_id', $request -> product_brand_id);
        }
        if( !empty($request -> is_featured) )
        {
            $record -> where('is_featured', $request -> is_featured);
        }
        if( !empty($request -> with_freight) )
        {
            $record -> where('with_freight', $request -> with_freight);
        }
        $record->with(['product_brand', 'product_category', 'product_subcategory']);
        $record->orderBy('id', 'DESC');

        $data           = [];
        $data[]         = ['ID', 'PRODUCTO', 'MODELO', 'MARCA', 'CATEGORIA', 'SUBCATEGORIA', 'PRECIO'];
        foreach($record -> get() AS $entry)
        {
            $data[] = [
                    $entry -> id
                ,   $entry -> title
                ,   $entry -> model
                ,   $entry -> product_brand -> title
                ,   $entry -> product_category -> title
                ,   $entry -> product_subcategory -> title
                ,   $entry -> price
            ];
        }

        $file = 'storage/'.ImagesSettings::DOCUMENTS_FOLDER.'/'.date('YmdHis').'_equipar_productos_price_update.xlsx';
        SimpleXLSXGen::fromArray($data)
            ->setDefaultFontSize(12)
            ->saveAs($file);
        return $file;
    }

    public function update_massive(Request $request)
    {
        $counter = 0;
        foreach($request->dataset AS $data)
        {
            $product = Product::find($data['id']);
            if( $product )
            {
                $product -> update(['price' => $data['price']]);
                $counter++;
            }
        }
        return response() -> json([
                'success'   => TRUE
            ,   'message'   => "Se actualizaron {$counter} productos correctamente."
        ]);
    }

    public function update_massive_file(ProductPriceRequest $request)
    {
        $validated                  = $request->validated();
        $stored                     = parent::store_file($request->file('new_prices'), 'equipar productos price upgrade', ImagesSettings::DOCUMENTS_FOLDER);
        $validated['new_prices']    = $stored;
        $validated['is_blocked']    = TRUE;

        if( $xlsx = SimpleXLSX::parse(Storage::disk('public')->path(ImagesSettings::DOCUMENTS_FOLDER.$stored)) )
        {
            if( ProductPrice::create($validated) )
            {
                $counter = 0;
                foreach($xlsx->rows() AS $idx => $row)
                {
                    if( $idx == 0 )
                    { continue; }

                    $product = Product::find($row[0]);
                    if( $product )
                    {
                        $product -> update(['price' => $row[6]]);
                        $counter++;
                    }
                }
                return response() -> json([
                        'success'   => TRUE
                    ,   'message'   => "Se actualizaron {$counter} productos correctamente."
                ]);
            }
        }
        return response() -> json([
                'success'   => FALSE
            ,   'message'   => 'Un error impidió guardar el archivo y los precios relacionados.'
        ], 500);
    }
}
