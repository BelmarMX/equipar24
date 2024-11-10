<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function toggle_dark_mode()
    {
        $user = auth()->user();
        $user->dark_mode = !$user->dark_mode;
        $user->save();

        return Redirect::back();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('dashboard.users.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.users.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = User::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of = User::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('action', function ($record) use ($restore) {
                $actions    = parent::set_actions('users', 'title', FALSE, $restore);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.users.create-edit', [
                'resource'  => 'users'
            ,   'record'    => new User()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $created = User::create($request -> validated());
        return redirect() -> route('users.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.users.create-edit', [
                'resource'  => 'users'
            ,   'record'    => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request -> validated());
        return redirect() -> route('users.index', ['updated' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect() -> route('users.archived', ['deleted' => $user->id]);
    }

    public function restore($user_id)
    {
        $user = User::onlyTrashed() -> find($user_id);
        $user->restore();
        return redirect() -> route('users.index', ['restored' => $user->id]);
    }
}
