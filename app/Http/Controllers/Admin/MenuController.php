<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $menus = Menu::all();

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('menu_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        abort_if(Gate::denies('menu_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $fields = Arr::except($menu->getAttributes(), ['id', 'route_name', 'status', 'deleted_at', 'created_at', 'updated_at']);
        $redirect_route = route('admin.menus.index');
        $label = 'menu';

        return view('admin.common.show', compact('label', 'fields', 'redirect_route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        abort_if(Gate::denies('menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        abort_if(Gate::denies('menu_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $menu->update($request->all());

        return redirect()->route('admin.menus.index')->with('success', __('global.updated_success'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('menu_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
}
