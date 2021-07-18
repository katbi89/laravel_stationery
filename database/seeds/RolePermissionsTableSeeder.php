<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where(['name' => 'admin'])->first();

        $role->permissions()->sync(Permission::all()->pluck('id'));

        $role = Role::where(['name' => 'manager'])->first();

        $role->permissions()->sync(Permission::all()->pluck('id'));

    }
}
