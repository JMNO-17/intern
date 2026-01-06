<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->roleRepository->all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        $permissions = $permissions->map(function ($permission) {
            $prefix = explode('_', $permission['name'])[0];
            $permission['group'] = $prefix.'s';

            return $permission;
        });
        $permissions = $permissions->groupBy('group');

        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1',
        ]);
        $role = $this->roleRepository->store($request->all());
        $permissions = $request->input('permissions', []);
        $this->roleRepository->assignPermission($permissions, $role);

        return redirect()->route('admin.roles.index')->with('success', __('global.created_success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::all();
        $permissions = $permissions->map(function ($permission) {
            $prefix = explode('_', $permission['name'])[0];
            $permission['group'] = $prefix.'s';

            return $permission;
        });
        $permissions = $permissions->groupBy('group');
        $role->load('permissions');

        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->roleRepository->update($request->all(), $role);
        $permissions = $request->input('permissions', []);
        $this->roleRepository->assignPermission($permissions, $role);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->roleRepository->softDelete($role);

        return redirect()->route('admin.roles.index');
    }
}
