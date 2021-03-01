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

		// animators permissions
		Permission::create(['name' => 'create events']);
		Permission::create(['name' => 'edit events']);
		Permission::create(['name' => 'delete events']);

		// articles permissions
        Permission::create(['name' => 'create articles']);
		Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'restore articles']);
        Permission::create(['name' => 'trash articles']);
        Permission::create(['name' => 'delete articles']);

		// categories permissions
		Permission::create(['name' => 'create category']);
		Permission::create(['name' => 'edit category']);
		Permission::create(['name' => 'delete category']);

		// create roles and assign created permissions
		$animator = Role::create(['name' => 'animator']);
		$animator->givePermissionTo([ 'create events', 'edit events' ]);

		$journalist = Role::create(['name' => 'journalist']);
		$journalist->givePermissionTo([ 'create articles', 'edit articles', 'trash articles' ]);

		$moderator = Role::create(['name' => 'journalists managers']);
		$moderator->givePermissionTo([ 'create articles', 'edit articles', 'delete articles', 'restore articles', 'trash articles', 'create category', 'edit category', 'delete category' ]);

		$role = Role::create(['name' => 'super-admin']);
		$role->givePermissionTo( Permission::all() );
	}
}
