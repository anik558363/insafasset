<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $featuredProperties = Property::featured()
        //     ->with(['primaryImage', 'category'])
        //     ->latest()
        //     ->take(6)
        //     ->get();
        
        
        $featuredProperties = Property::featured()
    ->with(['images', 'category'])
    ->latest()
    ->take(6)
    ->get();

        $categories = Category::withCount(['properties' => function ($q) {
            $q->where('status', 'available');
        }])->get();

        $testimonials = Testimonial::orderBy('id', 'desc')->take(6)->get();

        $stats = [
            'total_properties' => Property::where('status', 'available')->count(),
            'total_sold'       => Property::whereIn('status', ['sold', 'rented'])->count(),
            'happy_clients'    => (int) Setting::get('home_stats_clients', 500),
            'years_experience' => (int) Setting::get('home_stats_years', 10),
        ];

        return view('home', compact('featuredProperties', 'categories', 'testimonials', 'stats'));
    }
}
