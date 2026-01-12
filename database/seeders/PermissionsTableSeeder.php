<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            [
                'name'          => 'usermanagement_access',
                'display_name' => 'User Management Access',
            ],
            [
                'name' => 'userpermission_access',
                'display_name' => 'User Permission Access',
            ],
            // permissions
            [
                'name' => 'permission_access',
                'display_name' => 'Permission Access',
            ],
            // roles
            [
                'name' => 'role_access',
                'display_name' => 'Role Access',
            ],
            [
                'name' => 'role_create',
                'display_name' => 'Role Create',
            ],
            [
                'name' => 'role_edit',
                'display_name' => 'Role Edit',
            ],
            [
                'name' => 'role_delete',
                'display_name' => 'Role Delete',
            ],
            // users
            [
                'name' => 'user_access',
                'display_name' => 'User Access',
            ],
            [
                'name' => 'user_create',
                'display_name' => 'User Create',
            ],
            [
                'name' => 'user_edit',
                'display_name' => 'User Edit',
            ],
            [
                'name' => 'user_delete',
                'display_name' => 'User Delete',
            ],
            // profile
            [
                'name' => 'profile_password_edit',
                'display_name' => 'Profile Password Edit',
            ],

            // Setting
            [
                'name' => 'setting_edit',
                'display_name' => 'Setting Edit',
            ],

            // menu
            [
                'name' => 'menu_access',
                'display_name' => 'Menu Access',
            ],
            [
                'name' => 'menu_edit',
                'display_name' => 'Menu Edit',
            ],

            // section
            [
                'name' => 'section_access',
                'display_name' => 'Section Access',
            ],

            // bannerslider
            [
                'name' => 'bannerslider_access',
                'display_name' => 'BannerSlider Access',
            ],
            [
                'name' => 'bannerslider_create',
                'display_name' => 'BannerSlider Create',
            ],
            [
                'name' => 'bannerslider_edit',
                'display_name' => 'BannerSlider Edit',
            ],
            [
                'name' => 'bannerslider_delete',
                'display_name' => 'BannerSlider Delete',
            ],

            // content description
            [
                'name' => 'contentdescription_access',
                'display_name' => 'Content Description Access',
            ],
            [
                'name' => 'contentdescription_create',
                'display_name' => 'Content Description Create',
            ],
            [
                'name' => 'contentdescription_edit',
                'display_name' => 'Content Description Edit',
            ],
            [
                'name' => 'contentdescription_delete',
                'display_name' => 'Content Description Delete',
            ],

            // category

            [
                'name' => 'category_access',
                'display_name' => 'Category Access',
            ],
            [
                'name' => 'category_create',
                'display_name' => 'Category Create',
            ],
            [
                'name' => 'category_edit',
                'display_name' => 'Category Edit',
            ],
            [
                'name' => 'category_delete',
                'display_name' => 'Category Delete',
            ],

            // product

            [
                'name' => 'product_access',
                'display_name' => 'Product Access',
            ],
            [
                'name' => 'product_create',
                'display_name' => 'Product Create',
            ],
            [
                'name' => 'product_edit',
                'display_name' => 'Product Edit',
            ],
            [
                'name' => 'product_delete',
                'display_name' => 'Product Delete',
            ],

        ];

        foreach ($permissions as $permission) {
            $permissionData = Permission::where('name', $permission['name'])->first();
            if (!$permissionData) {
                Permission::create($permission);
            }
        }
    }
}
