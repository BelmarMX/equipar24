<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$user               = Auth()->user();
		$this->can_view     = $user->can('ver sucursales');
		$this->can_create   = $user->can('crear sucursales');
		$this->can_edit     = $user->can('editar sucursales');
		$this->can_delete   = $user->can('eliminar sucursales');
	}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.branches.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.branches.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = Branch::onlyTrashed();
            $restore    = $this->can_delete;
        }
        else
        {
            $dt_of = Branch::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('city_name', function ($record) {
                return $record->city->name ?? '🚫 Eliminada';
            })
            ->addColumn('state_name', function ($record) {
                return $record->state->name ?? '🚫 Eliminado';
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions    = parent::set_actions('branches', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

        return view('dashboard.branches.create-edit', [
                'resource'  => 'branches'
            ,   'record'    => new Branch()
            ,   'states'    => State::get_states_alias()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

        $created = Branch::create($request -> validated());
        return redirect() -> route('branches.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.branches.create-edit', [
                'resource'  => 'branches'
            ,   'record'    => $branch
            ,   'states'    => State::get_states_alias()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, Branch $branch)
    {
	    if( !$this->can_edit )
	    { abort(403); }

        $branch -> update($request -> validated());
        return redirect() -> route('branches.index', ['updated' => $branch -> id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $branch->delete();
        return redirect() -> route('branches.archived', ['deleted' => $branch -> id]);
    }

    public function restore($branch_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $branch = Branch::onlyTrashed() -> find($branch_id);
        $branch->restore();
        return redirect() -> route('branches.index', ['restored' => $branch -> id]);
    }
}
