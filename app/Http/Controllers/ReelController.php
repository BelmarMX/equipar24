<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\ReelRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPackage;
use App\Models\Promotion;
use App\Models\Reel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReelController extends Controller
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
			$this->can_view     = $user->can('ver reels');
			$this->can_create   = $user->can('crear reels');
			$this->can_edit     = $user->can('editar reels');
			$this->can_delete   = $user->can('eliminar reels');
		}
	}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.reels.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

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
            $restore    = $this->can_delete;
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
	        ->addColumn('paquete', function($record) {
		        if( is_null($record->product_package_id) )
		        {
			        return 'Sin paquete';
		        }
		        if( !$package = $record -> package )
		        {
			        return '🚫 Eliminado';
		        }
		        $vigency    = $package -> get_vigency();
		        $className  = $vigency->type == 'success'
			        ? 'text-emerald-400'
			        : ($vigency->type == 'danger'
				        ? 'text-red-400'
				        : 'text-indigo-400'
			        );

		        return "<span>{$package->title}<span>
                    <span class='block text-right {$className}'>{$package->get_vigency()->html}</span>";
	        })
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('reels', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['status','promocion', 'paquete', 'preview', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

        return view('dashboard.reels.create-edit', [
                'resource'      => 'reels'
            ,   'record'        => new Reel()
            ,   'promotions'    => Promotion::get_promotions()
            ,   'categories'    => ProductCategory::get_categories()
            ,   'packages'      => ProductPackage::get_packages()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReelRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

        $validated              = $request->validated();
        $video                  = parent::store_file($request->file('video'), $validated['title'], ImagesSettings::REEL_FOLDER);
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::REEL_FOLDER
            ,   TRUE
            ,   ImagesSettings::REEL_WIDTH_RX
            ,   ImagesSettings::REEL_HEIGHT_RX
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;
        $validated['video']     = $video ?? NULL;
        $validated['ends_at']   = Carbon::parse($validated['ends_at'])->endOfDay();

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
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.reels.create-edit', [
                'resource'      => 'reels'
            ,   'record'        => $reel
            ,   'rcrd_products' => $reel->product_id ? Product::where('product_subcategory_id', $reel->product->product_subcategory_id)->get() : NULL
            ,   'promotions'    => Promotion::get_promotions()
            ,   'categories'    => ProductCategory::get_categories()
	        ,   'packages'      => ProductPackage::get_packages()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReelRequest $request, Reel $reel)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $video                  = parent::store_file($request->file('video'), $validated['title'], ImagesSettings::REEL_FOLDER, $reel->video);
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::REEL_FOLDER
            ,   TRUE
            ,   ImagesSettings::REEL_WIDTH_RX
            ,   ImagesSettings::REEL_HEIGHT_RX
            ,   $reel->image
            ,   NULL
            ,   $reel->image_rx
        );

        $validated['image']     = $stored -> full -> original   ?? $reel->image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $reel->image_rx;
        $validated['video']     = $video ?? $reel->video;
        $validated['ends_at']   = Carbon::parse($validated['ends_at'])->endOfDay();

        $reel -> update($validated);
        return redirect() -> route('reels.index', ['updated' => $reel->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reel $reel)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $reel->delete();
        return redirect() -> route('reels.archived', ['deleted' => $reel->id]);
    }

    public function restore($reel_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $reel = Reel::onlyTrashed() -> find($reel_id);
        $reel->restore();
        return redirect() -> route('reels.index', ['restored' => $reel->id]);
    }
}
