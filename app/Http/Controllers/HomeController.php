<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Product;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $abouts = About::with('section', 'media')->get();

        $sections = Section::has('products')->get();

        $products = Product::with(['section', 'media'])
        ->when(request('section_id'), function ($query) {
            $query->where('section_id', request('section_id'));
        })
        ->get();

        $services = Service::with(['section', 'media'])->get();


        return view('frontend.home', compact('abouts', 'products', 'sections', 'services'));
    }

    
}
