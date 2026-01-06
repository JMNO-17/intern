<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator_permissions = Permission::all();
        User::findOrFail(1)->permissions()->sync($administrator_permissions->pluck('id'));
        User::findOrFail(2)->permissions()->sync($administrator_permissions->pluck('id'));

        $manger_permissions = Role::find(3)->permissions;
        User::findOrFail(3)->permissions()->sync($manger_permissions->pluck('id'));

        $staff_permissions = Role::find(4)->permissions;
        User::findOrFail(4)->permissions()->sync($staff_permissions->pluck('id'));

        $user_permissions = Role::find(5)->permissions;
        User::findOrFail(5)->permissions()->sync($user_permissions->pluck('id'));
    }
}
