<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Reservation;
use App\Models\RoomMovement;
use Carbon\Carbon;

class FrontOfficeController extends Controller
{
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        
        $stats = [
            'available_rooms' => Room::where('room_status', 'available')->count(),
            'occupied_rooms' => Room::where('room_status', 'occupied')->count(),
            'reserved_rooms' => Room::where('room_status', 'reserved')->count(),
            'inhouse_guests' => Booking::where('status', 'confirmed')
                ->whereNotNull('checked_in_at')
                ->whereNull('checked_out_at')
                ->count(),
        ];

        return view('front-office.dashboard', compact('stats'));
    }

    // Rooms Display
    public function roomsDisplay()
    {
        $rooms = Room::with(['bookings' => function($query) {
            $query->where('status', 'confirmed')
                ->whereNull('checked_out_at');
        }])->get();

        return view('front-office.rooms.display', compact('rooms'));
    }

    // Reservations Calendar
    public function reservationsCalendar(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        $selectedDate = Carbon::parse($date);

        $reservations = Booking::where('status', 'confirmed')
            ->where('reservation_type', 'room')
            ->where(function($query) use ($selectedDate) {
                $query->whereBetween('checkin_date', [
                    $selectedDate->copy()->startOfMonth(),
                    $selectedDate->copy()->endOfMonth()
                ])
                ->orWhereBetween('checkout_date', [
                    $selectedDate->copy()->startOfMonth(),
                    $selectedDate->copy()->endOfMonth()
                ]);
            })
            ->with('assignedRoom')
            ->get();

        return view('front-office.reservations.calendar', compact('reservations', 'selectedDate'));
    }

    // In-House List
    public function inHouseList()
    {
        $bookings = Booking::where('status', 'confirmed')
            ->where('reservation_type', 'room')
            ->whereNotNull('checked_in_at')
            ->whereNull('checked_out_at')
            ->with(['assignedRoom', 'checkedInBy'])
            ->latest('checked_in_at')
            ->get();

        return view('front-office.inhouse.index', compact('bookings'));
    }

    // Check-in
    public function checkIn(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'assigned_room_id' => 'required|exists:rooms,id',
        ]);

        $room = Room::findOrFail($request->assigned_room_id);
        
        // Check if room is available
        if ($room->room_status !== 'available') {
            return redirect()->back()->with('error', 'Selected room is not available');
        }

        $booking->assigned_room_id = $request->assigned_room_id;
        $booking->checked_in_at = now();
        $booking->checked_in_by = auth()->id();
        $booking->status = 'confirmed';
        $booking->save();

        // Update room status
        $room->room_status = 'occupied';
        $room->save();

        return redirect()->back()->with('success', 'Guest checked in successfully');
    }

    // Check-out
    public function checkOut($id)
    {
        $booking = Booking::findOrFail($id);
        
        if (!$booking->checked_in_at) {
            return redirect()->back()->with('error', 'Guest has not checked in yet');
        }

        $booking->checked_out_at = now();
        $booking->checked_out_by = auth()->id();
        $booking->save();

        // Update room status if not booked for today
        if ($booking->assigned_room_id) {
            $room = Room::find($booking->assigned_room_id);
            $today = now()->format('Y-m-d');
            
            // Check if room has any future bookings starting today
            $hasFutureBooking = Booking::where('assigned_room_id', $room->id)
                ->where('status', 'confirmed')
                ->where('checkin_date', '>=', $today)
                ->where('id', '!=', $booking->id)
                ->exists();

            if (!$hasFutureBooking) {
                $room->room_status = 'available';
                $room->save();
            } else {
                $room->room_status = 'reserved';
                $room->save();
            }
        }

        return redirect()->back()->with('success', 'Guest checked out successfully');
    }

    // Register Walk-in Guest
    public function registerWalkIn(Request $request)
    {
        $request->validate([
            'names' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'assigned_room_id' => 'required|exists:rooms,id',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
        ]);

        $booking = new Booking();
        $booking->fill($request->all());
        $booking->booking_type = 'walkin';
        $booking->status = 'confirmed';
        $booking->checkin_date = $request->checkin_date;
        $booking->checkout_date = $request->checkout_date;
        $booking->checked_in_at = now();
        $booking->checked_in_by = auth()->id();
        $booking->balance_amount = $request->total_amount - ($request->paid_amount ?? 0);
        $booking->payment_status = $booking->balance_amount <= 0 ? 'paid' : 'partial';
        $booking->save();

        // Update room status
        $room = Room::find($request->assigned_room_id);
        $room->room_status = 'occupied';
        $room->save();

        return redirect()->route('front-office.inhouse')->with('success', 'Walk-in guest registered successfully');
    }

    // Move Guest to Another Room
    public function moveGuest(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'to_room_id' => 'required|exists:rooms,id',
            'reason' => 'nullable|string',
        ]);

        $fromRoom = Room::find($booking->assigned_room_id);
        $toRoom = Room::findOrFail($request->to_room_id);

        if ($toRoom->room_status !== 'available') {
            return redirect()->back()->with('error', 'Target room is not available');
        }

        // Record movement
        RoomMovement::create([
            'booking_id' => $booking->id,
            'from_room_id' => $booking->assigned_room_id,
            'to_room_id' => $request->to_room_id,
            'reason' => $request->reason,
            'moved_by' => auth()->id(),
        ]);

        // Update booking
        $booking->assigned_room_id = $request->to_room_id;
        $booking->save();

        // Update room statuses
        if ($fromRoom) {
            $fromRoom->room_status = 'available';
            $fromRoom->save();
        }
        
        $toRoom->room_status = 'occupied';
        $toRoom->save();

        return redirect()->back()->with('success', 'Guest moved to another room successfully');
    }

    // Update Room Status
    public function updateRoomStatus(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->room_status = $request->room_status;
        $room->save();

        return redirect()->back()->with('success', 'Room status updated successfully');
    }

    // View Reservations
    public function reservations(Request $request)
    {
        $startDate = $request->start_date ?? now()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->addDays(30)->format('Y-m-d');

        $reservations = Booking::where('reservation_type', 'room')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('checkin_date', [$startDate, $endDate])
                      ->orWhereBetween('checkout_date', [$startDate, $endDate]);
            })
            ->with(['assignedRoom', 'room'])
            ->latest()
            ->get();

        return view('front-office.reservations.index', compact('reservations', 'startDate', 'endDate'));
    }

    // Update Reservation Status
    public function updateReservationStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // Update room status if cancelled or no-show
        if (in_array($request->status, ['cancelled', 'No Show']) && $booking->assigned_room_id) {
            $room = Room::find($booking->assigned_room_id);
            $room->room_status = 'available';
            $room->save();
        }

        return redirect()->back()->with('success', 'Reservation status updated successfully');
    }

    // Sales Reports
    public function salesReport(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        $bookings = Booking::whereBetween('checkin_date', [$startDate, $endDate])
            ->where('status', 'confirmed')
            ->get();

        $totalSales = $bookings->sum('total_amount');
        $totalPaid = $bookings->sum('paid_amount');
        $totalBalance = $bookings->sum('balance_amount');

        return view('front-office.reports.sales', compact('bookings', 'totalSales', 'totalPaid', 'totalBalance', 'startDate', 'endDate'));
    }
}
