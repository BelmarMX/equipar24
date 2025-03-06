<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PromotionProductController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$user               = Auth()->user();
		$this->can_view     = $user->can('ver promociones');
		$this->can_create   = $user->can('crear promociones');
		$this->can_edit     = $user->can('editar promociones');
		$this->can_delete   = $user->can('eliminar promociones');
	}

    /**
     * Display a listing of the resource.
     */
    public function index(Promotion $promotion)
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.promotions.link.index', [
                'record'        => $promotion
            ,   'brands'        => ProductBrand::get_brands()
            ,   'categories'    => ProductCategory::get_categories()
        ]);
    }

    public function datatable(Request $request, Promotion $promotion)
    {
        $promotion_data             = PromotionProduct::where('promotion_id', $promotion->id)->get();
        $products_in_promo          = array_column($promotion->products()->get()->toArray(), 'id');

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
            ->addColumn('old_link', function($record) use ($products_in_promo){
                $prefix     = 'old_link';
                $readonly   = TRUE;
                $is_checked = in_array($record->id, $products_in_promo) ? 1 : 0;
                return view('dashboard.promotions.link.input', compact('prefix', 'readonly', 'record', 'is_checked')) -> render();
            })
            ->addColumn('new_link', function($record) use ($products_in_promo){
                $prefix     = 'new_link';
                $readonly   = FALSE;
                $is_checked = in_array($record->id, $products_in_promo) ? 1 : 0;
                return view('dashboard.promotions.link.input', compact('prefix', 'readonly', 'record', 'is_checked')) -> render();
            })
            ->addColumn('prices', function($record) use($promotion_data){
                if( $promo = $promotion_data->where('product_id', $record->id)->first()  )
                {
                    return "<strong>$".number_format($promo->total)."</strong><br>
                        <span style='text-decoration: line-through;'>$".number_format($promo->original_price)."</span>";
                }
                else
                {
                    return "$".number_format($record->price);
                }
            })
            ->rawColumns(['old_link', 'new_link', 'prices'])
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PromotionProduct $promotion_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromotionProduct $promotion_product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PromotionProduct $promotion_product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromotionProduct $promotion_product)
    {
        //
    }

    public function update_massive(Request $request, Promotion $promotion)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $news = 0;
        $upds = 0;
        $olds = 0;
        foreach($request->dataset AS $data)
        {
            $product            = Product::find($data['id']);
            $promoProduct       = PromotionProduct::where('promotion_id', $promotion->id)->where('product_id',$product->id)->first();

            if( $data['linked'] == 1 )
            {
                $with_promotion = $promotion->calculate($product);
                if( $promoProduct )
                {
                    $promoProduct->original_price    = $with_promotion->original_price;
                    $promoProduct->discount          = $with_promotion->discount;
                    $promoProduct->total             = $with_promotion->total;
                    $promoProduct->save();
                    $upds++;
                }
                else
                {
                    PromotionProduct::create([
                            'promotion_id'      => $promotion->id
                        ,   'product_id'        => $product->id
                        ,   'original_price'    => $with_promotion->original_price
                        ,   'discount'          => $with_promotion->discount
                        ,   'total'             => $with_promotion->total
                    ]);
                    $news++;
                }
            }
            elseif( $data['linked'] == 0 && $promoProduct )
            {
                $promoProduct->delete();
                $olds++;
            }
        }
        return response() -> json([
                'success'   => TRUE
            ,   'message'   => "Se guardaron {$news} nuevos productos, actualizados {$upds} y {$olds} fueron borrados."
        ]);
    }
}
