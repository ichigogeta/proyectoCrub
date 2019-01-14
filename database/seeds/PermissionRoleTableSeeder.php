<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        $role = Role::where('name', 'administrador')->firstOrFail();
        //1 Browse_admin, 6 y 8 Menus 36-40 páginas
        $permissions = Permission::whereIn('id', [1, 6, 8, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41])->get();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );
    }
}
