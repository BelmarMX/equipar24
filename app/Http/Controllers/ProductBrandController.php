<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\ProductBrandRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
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
            ,   TRUE
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

    public function reorder()
    {
        return view('dashboard.productBrands.order', [
                'subtitle'  => 'Reordenar'
            ,   'records'   => ProductBrand::get_brands()
        ]);
    }

    public function update_order(Request $request)
    {
        foreach($request->order AS $order)
        {
            $brand        = ProductBrand::find($order['id']);
            $brand->order = $order['position'];
            $brand->save();
        }

        return response()->json(['success'=>TRUE, 'message'=>'Orden actualizado']);
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

    public function show_brand($slug_brand)
    {
        $product_brand          = ProductBrand::where('slug', $slug_brand)->firstOrFail();
        $product_category       = NULL;
        $column                 = 'id';
        $sort                   = 'DESC';
        if( !empty($_GET['sort']) && $_GET['sort'] == 'y' )
        {
            switch($_GET['orderby'])
            {
                case 'min':
                    $column             = 'price';
                    $sort               = 'ASC';
                    break;
                case 'max':
                    $column             = 'price';
                    break;
                case 'az':
                    $column             = 'title';
                    $sort               = 'ASC';
                    break;
                case 'za':
                    $column             = 'title';
                    break;
            }
        }
        $entries                = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where('product_brand_id', $product_brand->id)
            ->orderBy($column, $sort)
            ->paginate(24);
        $related_categories     = ProductBrand::get_product_categories_of_brand($product_brand->id);

        return view('web.products.marca-productos', array_merge(
                Navigation::get_static_data(['banner', 'reels', 'articles'])
            ,   compact('product_brand', 'entries', 'product_category', 'related_categories')
        ));
    }

    public function show_category($slug_brand, $slug_category)
    {
        $product_brand          = ProductBrand::where('slug', $slug_brand)->firstOrFail();
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $column                 = 'id';
        $sort                   = 'DESC';
        if( !empty($_GET['sort']) && $_GET['sort'] == 'y' )
        {
            switch($_GET['orderby'])
            {
                case 'min':
                    $column             = 'price';
                    $sort               = 'ASC';
                    break;
                case 'max':
                    $column             = 'price';
                    break;
                case 'az':
                    $column             = 'title';
                    $sort               = 'ASC';
                    break;
                case 'za':
                    $column             = 'title';
                    break;
            }
        }
        $entries                = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where('product_brand_id', $product_brand->id)
            ->where('product_category_id', $product_category->id)
            ->orderBy($column, $sort)
            ->paginate(24);

        $related_brands         = ProductBrand::get_brands_of_category($product_category->id);
        $related_categories     = ProductBrand::get_product_categories_of_brand($product_brand->id);
        $related_subcategories  = ProductBrand::get_product_subcategories_of_brand($product_brand->id, $product_category->id);

        return view('web.products.marca-productos', array_merge(
            Navigation::get_static_data(['banner', 'reels', 'articles'])
            ,   compact('product_brand', 'entries', 'product_category', 'related_categories', 'related_subcategories', 'related_brands')
        ));
    }

    public function show_subcategory($slug_brand, $slug_category, $slug_subcategory)
    {
        $product_brand          = ProductBrand::where('slug', $slug_brand)->firstOrFail();
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $product_subcategory    = ProductSubcategory::where('slug', $slug_subcategory)->firstOrFail();
        $column                 = 'id';
        $sort                   = 'DESC';
        if( !empty($_GET['sort']) && $_GET['sort'] == 'y' )
        {
            switch($_GET['orderby'])
            {
                case 'min':
                    $column             = 'price';
                    $sort               = 'ASC';
                    break;
                case 'max':
                    $column             = 'price';
                    break;
                case 'az':
                    $column             = 'title';
                    $sort               = 'ASC';
                    break;
                case 'za':
                    $column             = 'title';
                    break;
            }
        }
        $entries                = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where('product_brand_id', $product_brand->id)
            ->where('product_category_id', $product_category->id)
            ->where('product_subcategory_id', $product_subcategory->id)
            ->orderBy($column, $sort)
            ->paginate(24);

        $related_brands         = ProductBrand::get_brands_of_category($product_category->id);
        $related_categories     = ProductBrand::get_product_categories_of_brand($product_brand->id);
        $related_subcategories  = ProductBrand::get_product_subcategories_of_brand($product_brand->id, $product_category->id);

        return view('web.products.marca-productos', array_merge(
            Navigation::get_static_data(['banner', 'reels', 'articles'])
            ,   compact('product_brand', 'entries', 'product_category', 'product_subcategory', 'related_categories', 'related_subcategories', 'related_brands')
        ));
    }
}
