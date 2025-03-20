<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;
	private $can_view_admins;

	public function __construct()
	{
		$this->can_view         = FALSE;
		$this->can_view_admins  = FALSE;
		$this->can_create       = FALSE;
		$this->can_edit         = FALSE;
		$this->can_delete       = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view         = $user->can('ver roles');
			$this->can_view_admins  = $user->can('ver administradores');
			$this->can_create       = $user->can('crear roles');
			$this->can_edit         = $user->can('editar roles');
			$this->can_delete       = $user->can('eliminar roles');
		}
	}
	public function index()
	{
		if( !$this->can_view )
		{ abort(403); }

		return view('dashboard.roles.index', [
			'subtitle' => 'Registros activos'
		]);
	}

	public function archived()
	{
		if( !$this->can_delete )
		{ abort(403); }

		return view('dashboard.roles.index', [
				'subtitle'      => 'Registros eliminados'
			,   'with_trashed'  => TRUE
		]);
	}

	public function datatable(Request $request)
	{
		if( !$this->can_view )
		{ abort(403); }

		$restore        = FALSE;
		$dt_of          = Role::query();

		$dt_of->whereNot('name', 'webmaster');
		if( !$this->can_view_admins )
		{
			$dt_of->whereNot('name', 'admin');
		}

		return DataTables::of($dt_of)
			->addColumn('permissions', function($record){
				$permissions    = [];
				if( $record->name == 'webmaster' || $record->name == 'admin' )
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
				$actions    = parent::set_actions('roles', 'name', FALSE, $restore, $this->can_edit, $this->can_delete);
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

		return view('dashboard.roles.create-edit', [
				'resource'      => 'roles'
			,   'record'        => new Role()
			,   'permissions'   => Permission::orderBy('name')->get()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(RoleRequest $request)
	{
		if( !$this->can_create )
		{ abort(403); }

		$validated  = $request->validated();
		$created    = Role::create($validated);
		$created->syncPermissions($validated['permissions']);

		return redirect() -> route('roles.index', compact('created'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Role $role)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Role $role)
	{
		if( !$this->can_edit )
		{ abort(403); }

		return view('dashboard.roles.create-edit', [
				'resource'      => 'roles'
			,   'record'        => $role
			,   'permissions'   => Permission::orderBy('name')->get()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(RoleRequest $request, Role $role)
	{
		if( !$this->can_edit )
		{ abort(403); }

		$validated  = $request->validated();
		$role->update($validated);
		$role->syncPermissions($validated['permissions']);
		return redirect() -> route('roles.index', ['updated' => $role->id]);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Role $role)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$role->delete();
		return redirect() -> route('roles.archived', ['deleted' => $role->id]);
	}

	public function restore($role_id)
	{
		if( !$this->can_delete )
		{ abort(403); }

		$role = Role::onlyTrashed() -> find($role_id);
		$role->restore();
		return redirect() -> route('roles.index', ['restored' => $role->id]);
	}
}
