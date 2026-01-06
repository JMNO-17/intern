<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Section;

class SiteMapController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        $sections = Section::all();
        return view('admin.sitemaps.index', compact('menus', 'sections'));
    }
}
