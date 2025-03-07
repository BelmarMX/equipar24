<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;
	private $can_view_admins;

	public function __construct()
	{
		$this->can_view         = FALSE;
		$this->can_create       = FALSE;
		$this->can_edit         = FALSE;
		$this->can_delete       = FALSE;
		$this->can_view_admins  = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view         = $user->can('ver usuarios');
			$this->can_view_admins  = $user->can('ver administradores');
			$this->can_create       = $user->can('crear usuarios');
			$this->can_edit         = $user->can('editar usuarios');
			$this->can_delete       = $user->can('eliminar usuarios');
		}
	}

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
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.users.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

        return view('dashboard.users.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
	    if( !$this->can_view )
	    { abort(403); }

        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = User::onlyTrashed();
            $restore    = $this->can_delete;
        }
        else
        {
            $dt_of = User::query();
        }

        $dt_of->withoutRole('webmaster');
        if( !$this->can_view_admins )
        {
            $dt_of->withoutRole('admin');
        }

        return DataTables::of($dt_of)
            ->addColumn('roles', function($record){
                return implode(', ', $record->getRoleNames()->toArray());
            })
            ->addColumn('permissions', function($record){
                $permissions    = [];
                $roles          = $record->getRoleNames()->toArray();
                if( in_array('webmaster', $roles) || in_array('admin', $roles) )
                {
                    $permissions = ["<small style='min-width: 74px; text-align: center;' class='px-2 py-1 inline-block rounded-xl bg-green-500 text-white uppercase'>Todos</small>"];
                }
                else
                {
	                $ver        = 0;
	                $crear      = 0;
	                $editar     = 0;
	                $eliminar   = 0;
                    foreach($record->getAllPermissions()->toArray() AS $permission)
                    {
                        if( Str::contains($permission['name'], 'crear') )
                        { $crear++; }
                        elseif( Str::contains($permission['name'], 'editar') )
                        { $editar++; }
                        elseif( Str::contains($permission['name'], 'eliminar') )
                        { $eliminar++; }
						else
						{ $ver++; }
                    }

					$ver_opacity        = $ver == 0 ? 200 : 500;
					$crear_opacity      = $crear == 0 ? 200 : 500;
					$editar_opacity     = $editar == 0 ? 200 : 500;
					$eliminar_opacity   = $eliminar == 0 ? 200 : 500;

	                $permissions['ver']         = "<small style='min-width: 74px; text-align: center;' class='mt-1 px-2 py-1 inline-block rounded-xl bg-sky-{$ver_opacity} text-white uppercase'>VER: $ver</small>";
	                $permissions['crear']       = "<small style='min-width: 74px; text-align: center;' class='mt-1 px-2 py-1 inline-block rounded-xl bg-blue-{$crear_opacity} text-white uppercase'>CREAR: $crear</small>";
	                $permissions['editar']      = "<small style='min-width: 74px; text-align: center;' class='mt-1 px-2 py-1 inline-block rounded-xl bg-amber-{$editar_opacity} text-white uppercase'>EDITAR: $editar</small>";
	                $permissions['eliminar']    = "<small style='min-width: 74px; text-align: center;' class='mt-1 px-2 py-1 inline-block rounded-xl bg-red-{$eliminar_opacity} text-white uppercase'>ELIMINAR: $eliminar</small>";
                }
                return implode(' ', $permissions);
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions    = parent::set_actions('users', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['permissions', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

        return view('dashboard.users.create-edit', [
                'resource'  => 'users'
            ,   'record'    => new User()
            ,   'roles'         => Role::whereNotIn('name', ['webmaster'])->get()
            ,   'permissions'   => Permission::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
	    if( !$this->can_create )
	    { abort(403); }

		$validated  = $request->validated();
        $created    = User::create($validated);
		$created->syncRoles($validated['role']);
		$created->sendEmailVerificationNotification();

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
	    if( !$this->can_edit )
	    { abort(403); }

        return view('dashboard.users.create-edit', [
                'resource'      => 'users'
            ,   'record'        => $user
            ,   'roles'         => Role::whereNotIn('name', ['webmaster'])->get()
            ,   'permissions'   => Permission::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
	    if( !$this->can_edit )
	    { abort(403); }

		$validated  = $request->validated();
        $user->update($validated);
		if( !empty($validated['original_role']) && $validated['original_role'] != $validated['role'] )
		{
			$user->removeRole($validated['original_role']);
			$user->syncRoles($validated['role']);
		}
		elseif( empty($validated['original_role']) )
		{
			$user->syncRoles($validated['role']);
		}
        return redirect() -> route('users.index', ['updated' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $user->delete();
        return redirect() -> route('users.archived', ['deleted' => $user->id]);
    }

    public function restore($user_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $user = User::onlyTrashed() -> find($user_id);
        $user->restore();
        return redirect() -> route('users.index', ['restored' => $user->id]);
    }
}
