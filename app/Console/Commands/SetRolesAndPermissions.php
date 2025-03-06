<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SetRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta la inserción de los Roles y Permisos por default';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $webmaster              = Role::create(['name' => 'webmaster']);
        $admin                  = Role::create(['name' => 'admin']);
        $auditor                = Role::create(['name' => 'auditor']);
        $editor                 = Role::create(['name' => 'editor']);
        $editor_limited         = Role::create(['name' => 'editor limitado']);
        $soporte                = Role::create(['name' => 'soporte']);
        $usuario                = Role::create(['name' => 'usuario']);

        Permission::create(['name' => 'ver administradores']);
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'ver estados']);
        Permission::create(['name' => 'ver ciudades']);
        Permission::create(['name' => 'ver contactos']);
        Permission::create(['name' => 'ver cotizaciones']);
        Permission::create(['name' => 'ver banners']);
        Permission::create(['name' => 'ver reels']);
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'ver precios']);
        Permission::create(['name' => 'ver fletes']);
        Permission::create(['name' => 'ver promociones']);
        Permission::create(['name' => 'ver proyectos']);
        Permission::create(['name' => 'ver blog']);
        Permission::create(['name' => 'ver sucursales']);
        Permission::create(['name' => 'crear administradores']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'crear estados']);
        Permission::create(['name' => 'crear ciudades']);
        Permission::create(['name' => 'crear contactos']);
        Permission::create(['name' => 'crear cotizaciones']);
        Permission::create(['name' => 'crear banners']);
        Permission::create(['name' => 'crear reels']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'crear precios']);
        Permission::create(['name' => 'crear fletes']);
        Permission::create(['name' => 'crear promociones']);
        Permission::create(['name' => 'crear proyectos']);
        Permission::create(['name' => 'crear blog']);
        Permission::create(['name' => 'crear sucursales']);
        Permission::create(['name' => 'editar administradores']);
        Permission::create(['name' => 'editar perfil']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'editar estados']);
        Permission::create(['name' => 'editar ciudades']);
        Permission::create(['name' => 'editar contactos']);
        Permission::create(['name' => 'editar cotizaciones']);
        Permission::create(['name' => 'editar banners']);
        Permission::create(['name' => 'editar reels']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'editar precios']);
        Permission::create(['name' => 'editar fletes']);
        Permission::create(['name' => 'editar promociones']);
        Permission::create(['name' => 'editar proyectos']);
        Permission::create(['name' => 'editar blog']);
        Permission::create(['name' => 'editar sucursales']);
        Permission::create(['name' => 'eliminar administradores']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'eliminar estados']);
        Permission::create(['name' => 'eliminar ciudades']);
        Permission::create(['name' => 'eliminar contactos']);
        Permission::create(['name' => 'eliminar cotizaciones']);
        Permission::create(['name' => 'eliminar banners']);
        Permission::create(['name' => 'eliminar reels']);
        Permission::create(['name' => 'eliminar productos']);
        Permission::create(['name' => 'eliminar precios']);
        Permission::create(['name' => 'eliminar fletes']);
        Permission::create(['name' => 'eliminar promociones']);
        Permission::create(['name' => 'eliminar proyectos']);
        Permission::create(['name' => 'eliminar blog']);
        Permission::create(['name' => 'eliminar sucursales']);

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
        ];

        $view_permissions = [
                'ver usuarios'
            ,   'ver estados'
            ,   'ver ciudades'
            ,   'ver contactos'
            ,   'ver cotizaciones'
            ,   'ver usuarios'
            ,   'ver banners'
            ,   'ver reels'
            ,   'ver productos'
            ,   'ver precios'
            ,   'ver fletes'
            ,   'ver promociones'
            ,   'ver proyectos'
            ,   'ver blog'
            ,   'ver sucursales'
        ];

        $editor_permissions = [
                'ver estados'
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
            ,   'eliminar banners'
            ,   'eliminar reels'
            ,   'eliminar productos'
            ,   'eliminar precios'
            ,   'eliminar fletes'
            ,   'eliminar promociones'
            ,   'eliminar proyectos'
            ,   'eliminar blog'
            ,   'eliminar sucursales'
        ];

        $editor_limited_permissions = [
                'ver banners'
            ,   'ver reels'
            ,   'ver productos'
            ,   'ver proyectos'
            ,   'ver blog'
            ,   'ver sucursales'
            ,   'crear banners'
            ,   'crear reels'
            ,   'crear productos'
            ,   'crear proyectos'
            ,   'crear blog'
            ,   'crear sucursales'
            ,   'editar banners'
            ,   'editar reels'
            ,   'editar productos'
            ,   'editar proyectos'
            ,   'editar blog'
            ,   'editar sucursales'
        ];

        $soporte_permissions = [
                'ver contactos'
            ,   'ver cotizaciones'
            ,   'ver productos'
            ,   'ver promociones'
            ,   'crear contactos'
            ,   'crear cotizaciones'
            ,   'editar perfil'
            ,   'editar contactos'
            ,   'editar cotizaciones'
            ,   'editar productos'
        ];

        //$webmaster->syncPermissions(array_merge(['ver administradores','crear administradores','editar administradores','eliminar administradores'], $all_permisions));
        $admin->syncPermissions($all_permisions);
        $auditor->syncPermissions($view_permissions);
        $editor->syncPermissions($editor_permissions);
        $editor_limited->syncPermissions($editor_limited_permissions);
        $soporte->syncPermissions($soporte_permissions);

		$usuario = User::where('email', 'dispersion.mx@gmail.com')->first();
		$usuario->assignRole('webmaster');
    }
}
