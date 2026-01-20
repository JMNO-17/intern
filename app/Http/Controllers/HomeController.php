<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Product;
use App\Models\Section;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        // Get all about records
        $abouts = About::with('media')->get();
 
        // Get ONLY "About Us"
        $aboutUs = $abouts->firstWhere('name', 'About Us');

        // Products
        $sections = Section::has('products')->get();

        $products = Product::with(['section', 'media'])
            ->when(request('section_id'), function ($query) {
                $query->where('section_id', request('section_id'));
            })
            ->get();

        // Services
        $services = Service::with(['section', 'media'])->get();

        return view(
            'frontend.home',
            compact('abouts', 'aboutUs', 'products', 'sections', 'services')
        );
    }
}



