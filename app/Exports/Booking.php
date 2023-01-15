<?php

namespace App\Exports;

use App\Models\BookingRoom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class Booking implements FromView, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($request)
    {
        $this->request = $request;
    }



    public function view(): View
    {
        $room = $this->request->query('room');
        $status = $this->request->query('status');
        $start_date = $this->request->query('start_date');

        // LAST YEAR
        if ($start_date != null && $status != null && $room != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('date', $start_date)->where('status_booking', $status)->whereHas('room', function ($q) use ($room) {
                return $q->where('id', $room);
            })->get();
        } else if ($start_date != null && $status != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('date', $start_date)->where('status_booking', $status)->get();
        } else if ($start_date != null && $room != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('date', $start_date)->whereHas('room', function ($q) use ($room) {
                return $q->where('id', $room);
            })->get();
        } else if ($status != null && $room != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('status_booking', $status)->whereHas('room', function ($q) use ($room) {
                return $q->where('id', $room);
            })->get();
        } else if ($room != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->whereHas('room', function ($q) use ($room) {
                return $q->where('id', $room);
            })->get();
        } else if ($start_date != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('date', $start_date)->get();
        } else if ($status != null) {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->where('status_booking', $status)->get();
        } else {
            $bookingRoom = BookingRoom::with('participant', 'user', 'room')->get();
        }
        return view('admin.report-booking.excel.index', [
            'booking_rooms' => $bookingRoom
        ]);
    }
}
