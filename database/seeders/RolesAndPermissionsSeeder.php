<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Reset cached roles and permissions
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		// create permissions
		Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

		// create roles and assign created permissions
		$role = Role::create(['name' => 'journalist']);
		$role->givePermissionTo([ 'edit articles', 'delete articles', 'publish articles', 'unpublish articles' ]);

		$role = Role::create(['name' => 'super-admin']);
		$role->givePermissionTo(Permission::all());
	}
}
