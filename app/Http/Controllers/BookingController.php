<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Notifications\BookingStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('booking.create', compact('user'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100|regex:/^[a-zA-Z\s]+$/',
            'phone'        => 'required|string|max:20|unique:bookings|regex:/^[0-9\-\+\(\)]+$/',
            'email'        => 'nullable|email|max:150|unique:bookings',
            'address'      => 'nullable|string|max:255',
            'age'          => 'nullable|integer|min:1|max:120',
            'gender'       => 'nullable|in:male,female,other',
            'problems'     => 'required|string|max:1000',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'service_type' => 'required|in:eye_exam,fitting,consultation',
            'notes'        => 'nullable|string|max:500',
        ]);

        $data['user_id'] = Auth::id();
        Booking::create($data);

        return back()->with('success', 'Your booking request has been submitted. We will confirm shortly.');
    }

    public function index()
{
    $bookings = Booking::with('user')->latest()->paginate(15);
    $counts = [
        'pending'  => Booking::pending()->count(),
        'accepted' => Booking::accepted()->count(),
        'rejected' => Booking::rejected()->count(),
    ];
    return view('booking.index', compact('bookings', 'counts'));
}

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $booking->update(['status' => $request->status]);

        if ($booking->user && $booking->email) {
            $booking->user->notify(new BookingStatusNotification($booking));
        }

        $msg = "Booking {$request->status}.";
        $msg .= $booking->email ? " Email sent to {$booking->email}." : " No email on file.";

        return back()->with('success', $msg);
    }


}
