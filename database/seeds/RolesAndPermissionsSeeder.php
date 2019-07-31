<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();

        app()['cache']->forget('spatie.permission.cache');

        // view = listing, view detail
        // manage = create, edit, delete
        Permission::create(['name' => 'view dashboard']);

        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'manage admin']);

        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'manage user']);

        Permission::create(['name' => 'view product']);
        Permission::create(['name' => 'manage product']);

        Permission::create(['name' => 'view post']);
        Permission::create(['name' => 'manage post']);

        Permission::create(['name' => 'view subscriber']);
        Permission::create(['name' => 'manage subscriber']);

        Permission::create(['name' => 'manage setting']);
        Permission::create(['name' => 'view log']);

        Permission::create(['name' => 'manage package']);
        Permission::create(['name' => 'manage class category']);
        Permission::create(['name' => 'manage campaign']);
        Permission::create(['name' => 'manage bill']);

        // create roles an  d assign created permissions
        $role = Role::create(['name' => 'Root']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo([
            'view dashboard',
            'view admin',
            'view user',
            'manage user',
            'view product',
            'manage product',
            'view post',
            'manage post',
            'view subscriber',
            'manage subscriber',
            'manage setting',
            'view log',
            'manage package',
            'manage class category',
            'manage campaign',
            'manage bill',
        ]);

        $role = Role::create(['name' => 'Manager']);
        $role->givePermissionTo([
            'view dashboard',
            'view user',
//            'manage user',
            'view product',
            'manage product',
            'view post',
            'manage post',
            'view subscriber',
            'manage subscriber',
        ]);

        $role = Role::create(['name' => 'Viewer']);
        $role->givePermissionTo([
            'view dashboard',
            'view user',
            'manage user',
            'view product',
            'view post',
            'view subscriber',
        ]);

        $role = Role::create(['name' => 'Writer']);
        $role->givePermissionTo([
            'view dashboard',
            'view post',
            'manage post',
        ]);

        $user = User::find(1);

        if (!$user) {
            dd('user.id = 1 not found');
        }

        $user->assignRole('Root');

        $user = User::find(2);

        if (!$user) {
            dd('user.id = 2 not found');
        }

        $user->assignRole('Admin');
    }
}
