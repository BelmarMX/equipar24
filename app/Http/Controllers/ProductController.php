<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\PromotionProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    const DEFAULT_RAW_DESCRIPTION       = '{"time":1730082850296,"blocks":[{"id":"VlWyjSXHxZ","type":"paragraph","data":{"text":"<b>Dimensiones</b><br><b>Frente:</b> 0.00 m<br><b>Alto:</b> 0.00 m<br><b>Fondo: </b>0.00 m","alignment":"left"}}],"version":"2.30.6"}';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.products.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.products.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Product::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = Product::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('category', function($record) {
                return $record -> product_category -> title ?? '🚫 Eliminada';
            })
            ->addColumn('subcategory', function($record) {
                return $record -> product_subcategory -> title ?? '🚫 Eliminada';
            })
            ->addColumn('brand', function($record) {
                return $record -> product_brand -> title ?? '🚫 Eliminada';
            })
            ->addColumn('preview', function($record) {
                $show_thumbnail  = FALSE;
                return view('dashboard.partials.preview', compact('record', 'show_thumbnail')) -> render();
            })
            ->addColumn('gallery_count', function($record){
                return $record->product_galleries->count();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('products', 'title', TRUE, $restore, TRUE, TRUE, FALSE, ['route' => 'productGalleries.gallery', 'tooltip' => 'Agregar imágenes a la galería']);
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
        return view('dashboard.products.create-edit', [
                'resource'          => 'products'
            ,   'record'            => new Product()
            ,   'categories'        => ProductCategory::get_categories()
            ,   'brands'            => ProductBrand::get_brands()
            ,   'raw_description'   => self::DEFAULT_RAW_DESCRIPTION
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
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
        $sheet             = parent::store_file($request->file('data_sheet'), $validated['title'], ImagesSettings::PRODUCT_FOLDER.'fichas');

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;
        $validated['data_sheet']= $sheet ?? NULL;

        $created                = Product::create($validated);
        return redirect() -> route('products.index', compact('created'));
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
        return view('dashboard.products.create-edit', [
                'resource'      => 'products'
            ,   'record'        => $product
            ,   'categories'    => ProductCategory::get_categories()
            ,   'brands'        => ProductBrand::get_brands()
            ,   'raw_description'   => self::DEFAULT_RAW_DESCRIPTION
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_FOLDER
            ,   FALSE
            ,   ImagesSettings::PRODUCT_RX_WIDTH
            ,   ImagesSettings::PRODUCT_RX_HEIGHT
            ,   $product->image
            ,   NULL
            ,   $product->image_rx
        );
        $sheet             = parent::store_file($request->file('data_sheet'), $validated['title'], ImagesSettings::PRODUCT_FOLDER.'fichas/', $product->data_sheet);

        $validated['image']     = $stored -> full -> original   ?? $product->image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $product->image_rx;
        $validated['data_sheet']= $sheet ?? $product->data_sheet;

        $product -> update($validated);
        PromotionProduct::sync_prices_by_product($product);
        return redirect() -> route('products.index', ['updated' => $product->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect() -> route('products.archived', ['deleted' => $product->id]);
    }

    public function restore($product_id)
    {
        $product = Product::onlyTrashed() -> find($product_id);
        $product->restore();
        return redirect() -> route('products.index', ['restored' => $product->id]);
    }

    public function get_subcategories(Request $request)
    {
        return ProductSubcategory::get_subcategories($request->category_id);
    }

    public function get_filtrados(Request $request)
    {
        return Product::get_filtered($request->category_id, $request->subcategory_id);
    }

    public function search()
    {
        return [];
    }

    public function autocomplete()
    {
        return [];
    }

    public function show_categories()
    {
        return view('web.products.categorias-todas', Navigation::get_static_data());
    }

    public function show_category($slug_category)
    {
        $product_category   = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $entries            = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            -> where('product_category_id', $product_category->id)
            -> paginate(24);

        return view('web.products.categoria-productos', array_merge(
                Navigation::get_static_data(['reels', 'featured', 'articles'])
            ,   compact('product_category', 'entries')
        ));
    }

    public function show_subcategory($slug_category, $slug_subcategory)
    {
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $product_subcategory    = ProductSubcategory::where('slug', $slug_subcategory)->where('product_category_id', $product_category->id)->firstOrFail();
        $entries                = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            -> where('product_category_id', $product_category->id)
            -> where('product_subcategory_id', $product_subcategory->id)
            -> paginate(24);

        return view('web.products.categoria-productos', array_merge(
                Navigation::get_static_data(['reels', 'featured', 'articles'])
            ,   compact('product_category', 'product_subcategory', 'entries')
        ));
    }

    public function show_product($slug_category, $slug_subcategory, $slug_product)
    {
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $product_subcategory    = ProductSubcategory::where('slug', $slug_subcategory)->where('product_category_id', $product_category->id)->firstOrFail();
        $entry                  = Product::with(['product_brand', 'product_category', 'product_subcategory', 'product_galleries'])
            -> where('product_category_id', $product_category->id)
            -> where('product_subcategory_id', $product_subcategory->id)
            -> where('slug', $slug_product)
            -> firstOrFail();

        return view('web.products.producto-open', array_merge(
                Navigation::get_static_data(['banners', 'reels', 'featured', 'articles'])
            ,   compact('product_category', 'product_subcategory', 'entry')
        ));
    }

}
