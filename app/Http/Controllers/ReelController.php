<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ReelRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Reel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.reels.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.reels.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Reel::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = Reel::query();
        }

        if( isset($_GET['filter']) )
        {
            if( $_GET['filter'] == 'vigentes' )
            {
                $dt_of -> where('starts_at', '<=', now()) -> where('ends_at', '>=', now());
            }
            elseif( $_GET['filter'] == 'vencidas' )
            {
                $dt_of -> where('ends_at', '<', now());
            }
            elseif( $_GET['filter'] == 'proximas' )
            {
                $dt_of -> where('starts_at', '>', now());
            }
        }

        return DataTables::of($dt_of)
            ->addColumn('status', function($record) {
                $vigency = $record -> get_vigency();
                return view('dashboard.partials.status', compact('record', 'vigency')) -> render();
            })
            ->addColumn('promocion', function($record) {
                if( $record -> promotion_id == NULL )
                {
                    return 'Sin promoción';
                }
                if( !$promotion = $record -> promotion )
                {
                    return '🚫 Eliminada';
                }

                $vigency    = $promotion -> get_vigency();
                $discount   = $promotion -> discount_type == 'percentage'
                    ? "{$promotion -> amount}% de descuento"
                    : "Descuento de $ {$promotion -> amount} MXN";
                $className  = $vigency->type == 'success'
                    ? 'text-emerald-400'
                    : ($vigency->type == 'danger'
                        ? 'text-red-400'
                        : 'text-indigo-400'
                    );
                return "<span data-tooltip='$discount'>{$promotion->title}<span>
                    <span class='block text-right {$className}'>{$promotion->get_vigency()->html}</span>";
            })
            ->addColumn('producto', function($record) {
                if( is_null($record->product_id) )
                {
                    return 'Sin producto';
                }
                return $record->product->title ?? '🚫 Eliminado';
            })
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('reels', 'title', FALSE, $restore);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['status','promocion', 'preview', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.reels.create-edit', [
                'resource'      => 'reels'
            ,   'record'        => new Reel()
            ,   'promotions'    => Promotion::get_promotions()
            ,   'categories'    => ProductCategory::get_categories()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReelRequest $request)
    {
        $validated              = $request->validated();
        $video                  = parent::store_file($request->file('video'), $validated['title'], ImagesSettings::REEL_FOLDER);
        $validated['video']     = $video ?? NULL;
        $created                = Reel::create($validated);
        return redirect() -> route('reels.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reel $reel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reel $reel)
    {
        return view('dashboard.reels.create-edit', [
                'resource'      => 'reels'
            ,   'record'        => $reel
            ,   'rcrd_products' => Product::where('product_subcategory_id', $reel->product->product_subcategory_id)->get()
            ,   'promotions'    => Promotion::get_promotions()
            ,   'categories'    => ProductCategory::get_categories()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReelRequest $request, Reel $reel)
    {
        $validated              = $request -> validated();
        $video                  = parent::store_file($request->file('video'), $validated['title'], ImagesSettings::REEL_FOLDER, $reel->video);
        $validated['video']     = $video ?? $reel->video;

        $reel -> update($validated);
        return redirect() -> route('reels.index', ['updated' => $reel->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reel $reel)
    {
        $reel->delete();
        return redirect() -> route('reels.archived', ['deleted' => $reel->id]);
    }

    public function restore($reel_id)
    {
        $reel = Reel::onlyTrashed() -> find($reel_id);
        $reel->restore();
        return redirect() -> route('reels.index', ['restored' => $reel->id]);
    }
}
