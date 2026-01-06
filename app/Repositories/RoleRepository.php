<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleRepository implements RoleRepositoryInterface
{
    public function all(): Collection
    {
        return Role::all();
    }

    public function find($id)
    {
        return $this->all()->find($id);
    }

    public function store($data)
    {
        return Role::create($data);
    }

    public function update($data, $role)
    {
        return $role->update($data);
    }

    public function softDelete($role)
    {
        $role->delete();
    }

    public function forceDelete($role)
    {
        $role->forceDelete();
    }

    public function restore($id)
    {
        $this->all()->withTrashed()->find($id)->restore();
    }

    public function restoreAll()
    {
        $this->all()->onlyTrashed()->restore();
    }

    public function assignPermission($permissionInputs, $role)
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $role->syncPermissions($permissionInputs);
    }
}
