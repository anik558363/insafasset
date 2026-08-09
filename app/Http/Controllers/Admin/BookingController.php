<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['property', 'property.primaryImage'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $bookings = $query->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['property', 'property.images', 'payments']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status'         => ['required', 'in:pending,confirmed,rejected,cancelled'],
            'admin_note'     => ['nullable', 'string', 'max:500'],
            'advance_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['required', 'in:unpaid,paid,partial'],
        ]);

        $booking->update($request->only(['status', 'admin_note', 'advance_amount', 'payment_status']));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Booking updated.']);
        }

        return back()->with('success', 'Booking status updated.');
    }
}
