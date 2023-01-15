<?php

namespace App\Http\Controllers\room;

use App\Http\Controllers\Controller;
use App\Models\BookingRoom;
use App\Models\Participant;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Dotenv\Store\File\Paths;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class RoomDashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return the server IP if the client IP is not found using this method.
    }

    public function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function index()
    {

        $roomId = Auth::user()->room->id;
        $userId = Auth::user()->id;
        $today = Carbon::today()->toDateString();
        $rooms = Room::with('user')->get();
        $users = User::with('room')->get();
        $now = \Carbon\Carbon::now()->toDateString();

        $roomsIp = Room::with('user')->where('user_id', $userId)->first();

        $bookingToday = BookingRoom::where('room_id', $roomId)->where('status_booking', 'waiting')->whereDate('start_date', $now)->orderBy('start_date', 'asc')->get();

        $bookingOngoing = BookingRoom::where('room_id', $roomId)->where('status_booking', 'ongoing')->get();



        $getBookingToday = collect($bookingToday)->map(function ($to) {
            return [
                'title' => $to->title,
                'start' => \Carbon\Carbon::parse($to->start_date)->toFormattedDateString(),
                'for_human' => \Carbon\Carbon::parse($to->start_date)->diffForHumans(),

            ];
        });

        // return response()->json([
        //     'data' => $getTodayBooking
        // ]);



        $QrCode = '';
        $Link = '';

        $lineColor = '';

        if ($bookingOngoing->where('status_booking', 'ongoing')->values()->count() > 0) {
            $QrCodeData = $bookingOngoing->where('status_booking', 'ongoing')->values()[0];


            $bookingId = $QrCodeData->id;
            $title = $QrCodeData->title;
            $Link = env('APP_URL') . '/' . 'participants-attended' . '/' . $bookingId . '/' . 'presence';
            $QrCode = QrCode::size(100)->generate($Link);
        }
        if ($bookingOngoing->where('status_booking', 'ongoing')->values()->count() > 0) {
            $lineColor = '#F31111';
        } else {
            $lineColor = '#22df41';
        }

        $start_date = $bookingOngoing[0]->start_date ?? '-';
        $end_date = $bookingOngoing[0]->end_date ?? '-';
        $clientIP =  $this->getUserIpAddr();

        // return $bookingOngoing;
        return view('room.dashboard.index', [
            'rooms' => $rooms,
            'today' => $today,
            'booking_today' => $bookingToday,
            'QrCode' => (string) $QrCode,
            'linkQr' => $Link,
            'start_date' => $start_date,
            'bookingOngoing' => $bookingOngoing,
            'end_date' => $end_date,
            'lineColor' => $lineColor,
            'ip' => $clientIP,
            'ip_address' => $roomsIp,
            'getBookingToday' => $getBookingToday
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function apiDisplay()
    {
        $roomId = Auth::user()->room->id;
        $today = Carbon::today()->toDateString();
        $rooms = Room::with('user')->get();
        $users = User::with('room')->get();
        $now = \Carbon\Carbon::now()->toDateString();


        $bookingToday = BookingRoom::where('room_id', $roomId)->where('status_booking', 'waiting')->whereDate('start_date', $now)->orderBy('start_date', 'asc')->get();

        $bookingOngoing = BookingRoom::where('room_id', $roomId)->where('status_booking', 'ongoing')->get();



        $getBookingToday = collect($bookingToday)->map(function ($to) {

            return [

                'title' => $to->title,
                'start' => \Carbon\Carbon::parse($to->start_date)->toFormattedDateString(),
                'for_human' => \Carbon\Carbon::parse($to->start_date)->diffForHumans(),

            ];
        });

        $QrCode = '';
        $Link = '';

        $lineColor = '';

        if ($bookingOngoing->where('status_booking', 'ongoing')->values()->count() > 0) {
            $QrCodeData = $bookingOngoing->where('status_booking', 'ongoing')->values()[0];


            $bookingId = $QrCodeData->id;
            $title = $QrCodeData->title;
            $Link = env('APP_URL') . '/' . 'participants-attended' . '/' . $bookingId . '/' . 'display-presence';
            $QrCode = QrCode::size(100)->generate($Link);
        }
        if ($bookingOngoing->where('status_booking', 'ongoing')->values()->count() > 0) {
            $lineColor = '#F31111';
        } else {
            $lineColor = '#22df41';
        }



        $start_date = $bookingOngoing[0]->start_date ?? '-';
        $end_date = $bookingOngoing[0]->end_date ?? '-';
        $clientIP = request()->ip();

        // return $bookingOngoing;
        return response()->json([
            'rooms' => $rooms,
            'today' => $today,
            'booking_today' => $bookingToday,
            'QrCode' => (string) $QrCode,
            'linkQr' => $Link,
            'start_date' => $start_date,
            'bookingOngoing' => $bookingOngoing,
            'end_date' => $end_date,
            'lineColor' => $lineColor,
            'ip' => $clientIP,
            'getBookingToday' => $getBookingToday,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function reload(Request $request)
    {
        $bookingId = $request->booking_id;
        $updateReload = BookingRoom::find($bookingId);
        $updateReload->reload = 2;
        $updateReload->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
