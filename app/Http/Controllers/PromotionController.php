<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Http\Requests\PromotionRequest;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.promotions.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.promotions.index', [
            'subtitle' => 'Registros eliminados'
            , 'with_trashed' => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore = FALSE;
        if ($request->has('with_trashed') && $request->with_trashed == 'true') {
            $dt_of = Promotion::onlyTrashed();
            $restore = TRUE;
        } else {
            $dt_of = Promotion::query();
        }

        if (isset($_GET['filter'])) {
            if ($_GET['filter'] == 'vigentes') {
                $dt_of->where('starts_at', '<=', now())->where('ends_at', '>=', now());
            } elseif ($_GET['filter'] == 'vencidas') {
                $dt_of->where('ends_at', '<', now());
            } elseif ($_GET['filter'] == 'proximas') {
                $dt_of->where('starts_at', '>', now());
            }
        }

        return DataTables::of($dt_of)
            ->addColumn('preview', function ($record) {
                return view('dashboard.partials.preview', compact('record'))->render();
            })
            ->addColumn('status', function ($record) {
                $vigency = $record->get_vigency();
                return view('dashboard.partials.status', compact('record', 'vigency'))->render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions = parent::set_actions('promotions', 'title', TRUE, $restore, TRUE, TRUE, ['route' => 'promotionProducts.index', 'tooltip' => 'Vincular productos', 'fa_icon' => 'fa-cart-plus']);
                return view('dashboard.partials.actions', compact(['actions', 'record']))->render();
            })
            ->rawColumns(['preview', 'status', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.promotions.create-edit', [
            'resource' => 'promotions'
            , 'record' => new Promotion()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionRequest $request)
    {
        $validated = $request->validated();
        $stored = parent::store_all_images_from_request(
            $request->file('image')
            , $request->file('image_mv')
            , $validated['title']
            , ImagesSettings::PROMOS_FOLDER
            , FALSE
            , ImagesSettings::PROMOS_WIDTH_MV
            , ImagesSettings::PROMOS_HEIGHT_MV
        );

        $validated['image'] = $stored->full->original;
        $validated['image_rx'] = $stored->full->thumbnail ?? NULL;
        $validated['image_mv'] = $stored->mobile->original ?? NULL;

        $created = Promotion::create($validated);
        return redirect()->route('promotions.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('dashboard.promotions.create-edit', [
            'resource' => 'promotions'
            , 'record' => $promotion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $validated = $request->validated();
        $stored = parent::store_all_images_from_request(
            $request->file('image')
            , $request->file('image_mv')
            , $validated['title']
            , ImagesSettings::PROMOS_FOLDER
            , FALSE
            , ImagesSettings::PROMOS_WIDTH_MV
            , ImagesSettings::PROMOS_HEIGHT_MV
            , $promotion->image
            , $promotion->image_mv
            , $promotion->image_rx
        );

        $validated['image'] = $stored->full->original ?? $promotion->image;
        $validated['image_rx'] = $stored->full->thumbnail ?? $promotion->image_rx;
        $validated['image_mv'] = $stored->mobile->original ?? $promotion->image_mv;

        $promotion->update($validated);
        PromotionProduct::sync_prices_by_promotion($promotion);
        return redirect()->route('promotions.index', ['updated' => $promotion->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.archived', ['deleted' => $promotion->id]);
    }

    public function restore($promotion_id)
    {
        $promotion = Promotion::onlyTrashed()->find($promotion_id);
        $promotion->restore();
        return redirect()->route('promotions.index', ['restored' => $promotion->id]);
    }

}
