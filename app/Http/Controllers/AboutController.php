<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Setting;

class AboutController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('about', compact('testimonials'));
    }
}
