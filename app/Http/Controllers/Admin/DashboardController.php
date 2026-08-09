<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties' => Property::count(),
            'available'        => Property::where('status', 'available')->count(),
            'total_bookings'   => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'unread_messages'  => ContactMessage::where('is_read', false)->count(),
            'total_customers'  => User::where('role', 'customer')->count(),
        ];

        $recentBookings = Booking::with(['property', 'property.primaryImage'])
            ->latest()
            ->take(10)
            ->get();

        $recentMessages = ContactMessage::latest('created_at')->take(5)->get();

        $recentProperties = Property::with('primaryImage')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentMessages', 'recentProperties'));
    }
}
