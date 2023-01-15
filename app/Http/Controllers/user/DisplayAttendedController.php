<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingRoom;
use App\Models\Participant;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;


class DisplayAttendedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $booking = BookingRoom::with('participant')->find($id);
        // $booking = BookingRoom::with('participant')->get();
        // return $booking;
        return view('user.presence.display-attendance', [
            'booking' => $booking
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
    public function attendanceQrCode(Request $request)
    {
        try {

            DB::beginTransaction();

            $email = $request->email;
            $bookingId = $request->booking_id;
            // $getUserByEmail = User::where('email', $email)->first();

            $bookingRoom = BookingRoom::where('id', $bookingId)->with(['participant' => function ($q) use ($bookingId, $email) {
                return $q->where('booking_id', $bookingId)->where('email', $email);
            }])->first();

            // return response()->json([
            //     'data' => $bookingRoom,
            // ]);

            foreach ($bookingRoom->participant as $getBooking) {
                $participanId = $getBooking->id;
                $updateConfirm = Participant::find($participanId);
                $updateConfirm->participant_confirmation = 2;
                $updateConfirm->save();
            }




            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
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
