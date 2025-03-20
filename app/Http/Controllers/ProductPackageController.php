<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\ProductPackageRequest;
use App\Models\ProductPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductPackageController extends Controller
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
			$this->can_view     = $user->can('ver paquetes');
			$this->can_create   = $user->can('crear paquetes');
			$this->can_edit     = $user->can('editar paquetes');
			$this->can_delete   = $user->can('eliminar paquetes');
		}
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		if( !$this->can_view )
		{ abort(403); }

		return view('dashboard.productPackages.index', [
			'subtitle'          => 'Registros activos'
		]);
	}

	public function archived()
	{
		if( !$this->can_delete )
		{ abort(403); }

		return view('dashboard.productPackages.index', [
				'subtitle'      => 'Registros eliminados'
			,   'with_trashed'  => TRUE
		]);
	}

	public function datatable(Request $request)
	{
		$restore        = FALSE;
		if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
		{
			$dt_of      = ProductPackage::onlyTrashed();
			$restore    = $this->can_delete;
		}
		else
		{
			$dt_of      = ProductPackage::query();
		}

		return DataTables::of($dt_of)
			->addColumn('url', function($record){
				return route('paquetes-productos', $record->slug);
			})
			->addColumn('preview', function($record) {
				$show_thumbnail  = false;
				return view('dashboard.partials.preview', compact('record', 'show_thumbnail')) -> render();
			})
			->addColumn('product_count', function($record){
				return $record->products->count();
			})
			->addColumn('action', function ($record) use ($restore) {
				$actions            = parent::set_actions('productPackages', 'title', TRUE, $restore, $this->can_edit, $this->can_delete);
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

		return view('dashboard.productPackages.create-edit', [
				'resource'          => 'productPackages'
			,   'record'            => new ProductPackage()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(ProductPackageRequest $request)
	{
		if( !$this->can_create )
		{ abort(403); }

		$validated              = $request -> validated();
		$stored                 = parent::store_all_images_from_request(
				$request -> file('image')
			,   NULL
			,   $validated['title']
			,   ImagesSettings::PRODUCT_PACKAGE_FOLDER
			,   TRUE
			,   ImagesSettings::PRODUCT_PACKAGE_RX_WIDTH
			,   ImagesSettings::PRODUCT_PACKAGE_RX_HEIGHT
		);

		$validated['image']     = $stored -> full -> original;
		$validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

		$created                = ProductPackage::create($validated);
		$created->syncronize($validated['product_list']);
		return redirect() -> route('productPackages.index', compact('created'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(ProductPackage $productPackage)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(ProductPackage $productPackage)
	{
		if( !$this->can_edit )
		{ abort(403); }

		return view('dashboard.productPackages.create-edit', [
				'resource'      => 'productPackages'
			,   'record'        => $productPackage
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(ProductPackageRequest $request, ProductPackage $productPackage)
	{
		if( !$this->can_edit )
		{ abort(403); }

		$validated              = $request -> validated();
		$stored                 = parent::store_all_images_from_request(
				$request -> file('image')
			,   NULL
			,   $validated['title']
			,   ImagesSettings::PRODUCT_PACKAGE_FOLDER
			,   TRUE
			,   ImagesSettings::PRODUCT_PACKAGE_RX_WIDTH
			,   ImagesSettings::PRODUCT_PACKAGE_RX_HEIGHT
			,   $productPackage->image
			,   NULL
			,   $productPackage->image_rx
		);

		$validated['image']     = $stored -> full -> original   ?? $productPackage->image;
		$validated['image_rx']  = $stored -> full -> thumbnail  ?? $productPackage->image_rx;

		$productPackage -> update($validated);
		$productPackage->syncronize($validated['product_list']);
		return redirect() -> route('productPackages.index', ['updated' => $productPackage->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(ProductPackage $productPackage)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$productPackage->delete();
		return redirect() -> route('productPackages.archived', ['deleted' => $productPackage->id]);
	}

	public function restore($productPackage_id)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$productPackage = ProductPackage::onlyTrashed() -> find($productPackage_id);
		$productPackage->restore();
		return redirect() -> route('productPackages.index', ['restored' => $productPackage->id]);
	}

	public function show_package($slug_package)
	{
		$package  = ProductPackage::where('slug', $slug_package)->where('starts_at', '<=', now())->where('ends_at', '>=', now())->firstOrFail();
		$entries    = $package->products()->paginate(24);
		return view('web.products.paquete-productos', array_merge(
				Navigation::get_static_data(['reels', 'featured', 'articles'])
			,   compact('package', 'entries')
		));
	}
}
