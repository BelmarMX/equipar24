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
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    const DEFAULT_RAW_DESCRIPTION       = '{"time":1730082850296,"blocks":[{"id":"VlWyjSXHxZ","type":"paragraph","data":{"text":"<b>Dimensiones</b><br><b>Frente:</b> 0.00 m<br><b>Alto:</b> 0.00 m<br><b>Fondo: </b>0.00 m","alignment":"left"}}],"version":"2.30.6"}';
	const CATEGORIES_ICONS              = [
			'acero-inoxidable'                      => 'fa-scroll'
		,   'coccion'                               => 'fa-fire'
		,   'refrigeracion'                         => 'fa-snowflake'
		,   'utensilios'                            => 'fa-utensils'
		,   'almacenaje'                            => 'fa-dolly'
		,   'barras-de-servicio'                    => 'fa-kaaba'
		,   'equipo-menor'                          => 'fa-blender'
		,   'lavado-de-loza-y-cristaleria'          => 'fa-sink'
		,   'complementos'                          => 'fa-kitchen-set'
		,   'refacciones'                           => 'fa-screwdriver-wrench'

	];

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
    public function index($filter_type = NULL, $filter_id = NULL)
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.products.index', [
                'subtitle'      => 'Registros activos'
            ,   'filter_type'   => $filter_type
            ,   'filter_id'     => $filter_id
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.products.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request, $filter_type = NULL, $filter_id = NULL)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Product::onlyTrashed();
            $restore    = $this->can_delete;
        }
        else
        {
            $dt_of      = Product::query();
        }

        if( !empty($filter_type) )
        {
            switch($filter_type)
            {
                case 'brand':           $dt_of->where('product_brand_id', $filter_id);          break;
                case 'category':        $dt_of->where('product_category_id', $filter_id);       break;
                case 'subcategory':     $dt_of->where('product_subcategory_id', $filter_id);    break;
                case 'freight':         $dt_of->where('with_freight', !empty($filter_id));      break;
            }
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
            ->addColumn('promotions_count', function($record){
                return $record->promotions->count();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('products', 'title', TRUE, $restore, $this->can_edit, $this->can_delete, FALSE, ['route' => 'productGalleries.gallery', 'tooltip' => 'Agregar imágenes a la galería']);
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
	    if( !$this->can_create )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::PRODUCT_FOLDER
            ,   TRUE
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
	    if( !$this->can_delete )
	    { abort(403); }

        $product->delete();
        return redirect() -> route('products.archived', ['deleted' => $product->id]);
    }

    public function restore($product_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

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

    private function products_search_instance($like_text)
    {
        $return = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where(function($query) use ($like_text){
                    $query->where('title', 'LIKE', '%'.$like_text.'%');
                    $query->orWhere('model', 'LIKE', '%'.$like_text.'%');
            })
            ->where('in_stock', '=', true);
        if( empty($_GET['brand']) )
        {
            $return->orWhereHas('product_brand', function($query) use ($like_text) {
                $query->where('title', 'LIKE', '%'.$like_text.'%');
            });
        }
        if( empty($_GET['brand']) && empty($_GET['category']) )
        {
            $return->orWhereHas('product_category', function($query) use ($like_text) {
                $query->where('title', 'LIKE', '%'.$like_text.'%');
            })
                ->orWhereHas('product_subcategory', function($query) use ($like_text) {
                    $query->where('title', 'LIKE', '%'.$like_text.'%');
                });
        }
        return $return->distinct();
    }

    public function autocomplete(Request $request)
    {
        $return                 = [];
        if( empty($request['query']) )
        { return $return; }

        $products = $this->products_search_instance($request['query'])->orderBy('model')
            ->get();

        foreach($products AS $product)
        {
            $has_promo = $product->get_higer_active_promo();

            $price          = $product->price;
            $final_price    = $product->price;
            $discount       = 0;
            if( $has_promo )
            {
                $price          = $has_promo->original_price;
                $final_price    = $has_promo->total;
                $discount       = Navigation::percent($has_promo->original_price, $has_promo->total);
            }
            $full_search    = "{$product->title} | {$product->product_brand->title} | {$product->product_category->title} | {$product->product_subcategory->title}";

            // ? La llave name es la importante para encontrar los resultados y coincidencias
            $return[] = [
                    'id'            => $product->id
                ,   'slug'          => $product->slug
                ,   'name'          => $full_search
                ,   'title'         => $product->title
                ,   'model'         => $product->model
                ,   'category'      => $product->product_category->title
                ,   'subcategory'   => $product->product_subcategory->title
                ,   'brand'         => $product->product_brand->title
                ,   'price'         => $price
                ,   'final_price'   => $final_price
                ,   'con_flete'     => $product->with_freight
                ,   'discount'      => $discount
                ,   'image'         => $product->asset_url.$product -> image_rx
                ,   'image_path'    => $product -> image_rx
                ,   'route'         => route('producto-open', [$product->product_category->slug, $product->product_subcategory->slug, $product->slug])
            ];
        }

        return response() -> json($return);

    }

    public function results($termino)
    {
        $termino                = urldecode($termino);
        if( Str::contains($termino, '|') )
        {
            $termino            = trim(explode('|', $termino)[0]);
        }
        $entries                = $this->products_search_instance($termino);
        $all_results_query      = $entries;
        $all                    = $all_results_query->get()->toArray();

        if( !empty($_GET['brand']) )
        {
            $product_brand      = ProductBrand::where('slug', $_GET['brand'])->first();
            $entries->where('product_brand_id', $product_brand->id);
        }
        if( !empty($_GET['category']) )
        {
            $product_category   = ProductCategory::where('slug', $_GET['category'])->first();
            $entries->where('product_category_id', $product_category->id);
        }

        if( !empty($_GET['orderby']) )
        {
            switch($_GET['orderby'])
            {
                case 'az':
                    $entries->orderBy('title', 'ASC');
                break;
                case 'za':
                    $entries->orderBy('title', 'DESC');
                break;
                case 'min':
                    $entries->orderBy('price', 'ASC');
                break;
                case 'max':
                    $entries->orderBy('price', 'DESC');
                break;
            }
        }
        else
        {
            $entries->orderBy('id', 'DESC');
        }

        $entries                = $entries->paginate(24)->appends(request()->query());
        $brands_ids             = array_column($all, 'product_brand_id');
        $categories_ids         = array_column($all, 'product_category_id');
        $filtered_brands        = ProductBrand::whereIn('id', $brands_ids)->get();
        $filtered_categories    = ProductCategory::whereIn('id', $categories_ids)->get();

        return view('web.products.results', array_merge(
            Navigation::get_static_data(['reels', 'featured', 'articles'])
            ,   compact('termino', 'entries', 'filtered_brands', 'filtered_categories')
        ));
    }

    public function show_categories()
    {
	    $icon_map = self::CATEGORIES_ICONS;
        return view('web.products.categorias-todas', array_merge(
			Navigation::get_static_data()
			, compact('icon_map')
        ));
    }

    public function show_category($slug_category)
    {
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $related_brands         = ProductBrand::get_brands_of_category($product_category->id);

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
        $entries            = Product::with(['product_brand', 'product_category', 'product_subcategory'])
            ->where('product_category_id', $product_category->id)
            ->orderBy($column, $sort)
            ->paginate(24)
            ->appends(request()->query());

		$icon_map = self::CATEGORIES_ICONS;
	    $has_icon = $icon_map[$slug_category] ?? NULL;


        return view('web.products.categoria-productos', array_merge(
                Navigation::get_static_data(['reels', 'featured', 'articles'])
            ,   compact('product_category', 'related_brands', 'entries', 'has_icon')
        ));
    }

    public function show_subcategory($slug_category, $slug_subcategory)
    {
        $product_category       = ProductCategory::where('slug', $slug_category)->firstOrFail();
        $product_subcategory    = ProductSubcategory::where('slug', $slug_subcategory)->where('product_category_id', $product_category->id)->firstOrFail();
        $related_brands         = ProductBrand::get_brands_of_category($product_category->id);

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
            ->where('product_category_id', $product_category->id)
            ->where('product_subcategory_id', $product_subcategory->id)
            ->orderBy($column, $sort)
            ->paginate(24)
            ->appends(request()->query());

        return view('web.products.categoria-productos', array_merge(
                Navigation::get_static_data(['reels', 'featured', 'articles'])
            ,   compact('product_category', 'product_subcategory', 'related_brands', 'entries')
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
