<?php

namespace App\Http\Controllers;

use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.branches.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
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
            $restore    = TRUE;
        }
        else
        {
            $dt_of = Branch::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('city_name', function ($record) {
                return $record -> city -> name;
            })
            ->addColumn('state_name', function ($record) {
                return $record -> state -> name;
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions    = [
                        'field_name'    => 'title'
                    ,   'custom'        => [
                            'related'   => NULL
                        ,   'images'    => NULL
                        ,   'video'     => NULL
                        ,   'download'  => NULL
                    ]
                    ,   'divider'       => FALSE
                    ,   'edit'          => [
                            'enabled'   => !$restore
                        ,   'route'     => 'branches.edit'
                    ]
                    ,   'delete'        => [
                            'enabled'   => !$restore
                        ,   'route'     => 'branches.delete'
                    ]
                    ,   'restore'       => [
                            'enabled'   => $restore
                        ,   'route'     => 'branches.restore'
                    ]
                ];
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        dd($request -> validated());
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
        $branch -> update($request -> validated());
        return redirect() -> route('branches.index', ['updated' => $branch -> id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect() -> route('branches.archived', ['deleted' => $branch -> id]);
    }

    public function restore($branch_id)
    {
        $branch = Branch::onlyTrashed() -> find($branch_id);
        $branch->restore();
        return redirect() -> route('branches.index', ['restored' => $branch -> id]);
    }
}
