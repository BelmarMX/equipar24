<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    Permission::create(['name' => 'ver paquetes']);
	    Permission::create(['name' => 'crear paquetes']);
	    Permission::create(['name' => 'editar paquetes']);
	    Permission::create(['name' => 'eliminar paquetes']);
	    Permission::create(['name' => 'ver roles']);
	    Permission::create(['name' => 'crear roles']);
	    Permission::create(['name' => 'editar roles']);
	    Permission::create(['name' => 'eliminar roles']);

		$admin                      = Role::where('name', 'admin')->first();
	    $all_permisions = [
		        'ver usuarios'
		    ,   'ver estados'
		    ,   'ver ciudades'
		    ,   'ver contactos'
		    ,   'ver cotizaciones'
		    ,   'ver banners'
		    ,   'ver reels'
		    ,   'ver productos'
		    ,   'ver precios'
		    ,   'ver fletes'
		    ,   'ver promociones'
		    ,   'ver proyectos'
		    ,   'ver blog'
		    ,   'ver sucursales'
		    ,   'crear usuarios'
		    ,   'crear estados'
		    ,   'crear ciudades'
		    ,   'crear contactos'
		    ,   'crear cotizaciones'
		    ,   'crear banners'
		    ,   'crear reels'
		    ,   'crear productos'
		    ,   'crear precios'
		    ,   'crear fletes'
		    ,   'crear promociones'
		    ,   'crear proyectos'
		    ,   'crear blog'
		    ,   'crear sucursales'
		    ,   'editar usuarios'
		    ,   'editar perfil'
		    ,   'editar estados'
		    ,   'editar ciudades'
		    ,   'editar contactos'
		    ,   'editar cotizaciones'
		    ,   'editar banners'
		    ,   'editar reels'
		    ,   'editar productos'
		    ,   'editar precios'
		    ,   'editar fletes'
		    ,   'editar promociones'
		    ,   'editar proyectos'
		    ,   'editar blog'
		    ,   'editar sucursales'
		    ,   'eliminar usuarios'
		    ,   'eliminar estados'
		    ,   'eliminar ciudades'
		    ,   'eliminar contactos'
		    ,   'eliminar cotizaciones'
		    ,   'eliminar banners'
		    ,   'eliminar reels'
		    ,   'eliminar productos'
		    ,   'eliminar precios'
		    ,   'eliminar fletes'
		    ,   'eliminar promociones'
		    ,   'eliminar proyectos'
		    ,   'eliminar blog'
		    ,   'eliminar sucursales'
		    ,   'ver paquetes'
		    ,   'crear paquetes'
		    ,   'editar paquetes'
		    ,   'eliminar paquetes'
		    ,   'ver roles'
		    ,   'crear roles'
		    ,   'editar roles'
	    ];
		$admin->syncPermissions($all_permisions);
    }
}
