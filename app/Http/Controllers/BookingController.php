<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Property $property)
    {
        return view('bookings.create', compact('property'));
    }

    public function store(BookingRequest $request, Property $property)
    {
        $booking = Booking::create([
            ...$request->validated(),
            'property_id' => $property->id,
            'user_id'     => auth()->id(),
            'status'      => 'pending',
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => __('messages.booking_flash.submitted_ajax'),
                'booking_id' => $booking->id,
            ]);
        }

        return redirect()->route('properties.show', $property->slug)
            ->with('success', __('messages.booking_flash.submitted'));
    }
}
