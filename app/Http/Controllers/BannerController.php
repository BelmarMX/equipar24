<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BannerController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$user               = Auth()->user();
		$this->can_view     = $user->can('ver banners');
		$this->can_create   = $user->can('crear banners');
		$this->can_edit     = $user->can('editar banners');
		$this->can_delete   = $user->can('eliminar banners');
	}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		if( !$this->can_view )
		{ abort(403); }

        return view('dashboard.banners.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.banners.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Banner::onlyTrashed();
            $restore    = $this->can_delete;
        }
        else
        {
            $dt_of      = Banner::query();
        }

        return DataTables::of($dt_of)
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
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('banners', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['promocion', 'preview', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

        return view('dashboard.banners.create-edit', [
                'resource'      => 'banners'
            ,   'record'        => new Banner()
            ,   'promotions'    => Promotion::get_promotions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   $request -> file('image_mv')
            ,   $validated['title']
            ,   ImagesSettings::BANNER_FOLDER
            ,   FALSE
            ,   ImagesSettings::BANNER_WIDTH_MV
            ,   ImagesSettings::BANNER_HEIGHT_MV
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;
        $validated['image_mv']  = $stored -> mobile -> original ?? NULL;

        $created                = Banner::create($validated);
        return redirect() -> route('banners.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.banners.create-edit', [
                'resource'      => 'banners'
            ,   'record'        => $banner
            ,   'promotions'    => Promotion::get_promotions()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   $request -> file('image_mv')
            ,   $validated['title']
            ,   ImagesSettings::BANNER_FOLDER
            ,   FALSE
            ,   ImagesSettings::BANNER_WIDTH_MV
            ,   ImagesSettings::BANNER_HEIGHT_MV
            ,   $banner -> image
            ,   $banner -> image_mv
            ,   $banner -> image_rx
        );

        $validated['image']     = $stored -> full -> original   ?? $banner -> image;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? $banner -> image_rx;
        $validated['image_mv']  = $stored -> mobile -> original ?? $banner -> image_mv;

        $banner -> update($validated);
        return redirect() -> route('banners.index', ['updated' => $banner -> id]);
    }

    public function reorder()
    {
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.banners.order', [
                'subtitle'  => 'Reordenar'
            ,   'records'   => Banner::get_banners()
        ]);
    }

    public function update_order(Request $request)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        foreach($request->order AS $order)
        {
            $banner        = Banner::find($order['id']);
            $banner->order = $order['position'];
            $banner->save();
        }

        return response()->json(['success'=>TRUE, 'message'=>'Orden actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $banner->delete();
        return redirect() -> route('banners.archived', ['deleted' => $banner->id]);
    }

    public function restore($banner_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $banner = Banner::onlyTrashed() -> find($banner_id);
        $banner->restore();
        return redirect() -> route('banners.index', ['restored' => $banner->id]);
    }
}
