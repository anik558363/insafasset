<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Category;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['type', 'listing_type', 'division', 'district', 'area', 'min_price', 'max_price', 'min_size', 'max_size', 'category_id', 'bedrooms']);

        $query = Property::available()
            ->with(['primaryImage', 'category'])
            ->filter($filters)
            ->latest();

        if ($request->ajax()) {
            $properties = $query->paginate(9);
            $html = view('partials.property-cards', compact('properties'))->render();
            return response()->json([
                'html'         => $html,
                'has_more'     => $properties->hasMorePages(),
                'current_page' => $properties->currentPage(),
                'total'        => $properties->total(),
            ]);
        }

        $properties = $query->paginate(9);
        $categories = Category::all();

        $divisions = Property::select('division')->distinct()->whereNotNull('division')->pluck('division');
        $districts = Property::select('district')->distinct()->whereNotNull('district')->pluck('district');

        return view('properties.index', compact('properties', 'categories', 'filters', 'divisions', 'districts'));
    }

    public function show(Property $property)
    {
        $property->incrementViews();
        $property->load(['images', 'category', 'bookings']);

        $related = Property::available()
            ->where('id', '!=', $property->id)
            ->where('category_id', $property->category_id)
            ->with('primaryImage')
            ->take(3)
            ->get();

        return view('properties.show', compact('property', 'related'));
    }
}
