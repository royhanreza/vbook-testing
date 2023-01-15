<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailJob;
use App\Models\BookingRoom;
use App\Models\Participant;
use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\AddMailToMeeting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $users = User::where('role_id', '3')->get();
        $rooms = Room::where('id', $id)->first();
        // return $user;
        return view('user.booking.create', [
            'rooms' => $rooms,
            'users' => $users,
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
        $now = \Carbon\Carbon::now();

        $validator = Validator::make($request->all(), [
            'start_date'           => 'required|after:' . now(),
            'end_date'             => 'required|after:start_date',
        ], [
            'start_date.after' => "Tanggal Akhir Tidak boleh kurang dari waktu saat ini atau tanggal awal"
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Tanggal Akhir Tidak boleh kurang dari waktu saat ini atau tanggal awal',
                'errors' => [],
                'status' => true,
                'code' => 400,
            ], 400);
        }

        try {

            DB::beginTransaction();

            $newBooking = new BookingRoom();
            $newBooking->title = $request->title;
            $newBooking->user_id = Auth::user()->id;
            $newBooking->room_id = $request->room_id;
            $newBooking->department = $request->department;
            $newBooking->status = 1;
            $newBooking->status_booking = 'waiting';
            $newBooking->reminder = 'not';

            $roomChek = $request->room_id;
            $startChek = $request->start_date;

            $newBooking->date = $request->start_date;

            // return response()->json([
            //     'data' => json_decode($getEmailList),

            // ]);


            $bookingCheck = BookingRoom::where('room_id', $roomChek)->where('start_date', $startChek)->first();
            if ($bookingCheck) {
                // throw new Error('Maaf Email sudah pernah mengisi POST TEST');
                return response()->json([
                    'message' => 'Maaf Ruang dengan waktu Booking Di input Sudah di booking',
                    'errors' => [],
                    'status' => true,
                    'code' => 400,
                ], 400);
            } else {
                $newBooking->start_date = $request->start_date;
                $newBooking->end_date = $request->end_date;
            }

            $newBooking->save();

            $roomId = $request->room_id;


            $getRoom = Room::where('id', $roomId)->first();




            $bookingId = $newBooking->id;
            $title = $request->title;
            $Link = env('APP_URL') . '/' . 'participants-attended' . '/' . $bookingId . '/' . 'presence';
            $QrCode = QrCode::size(200)->generate($Link);

            $data = ([
                'title' => $request->title,
                'room' => $getRoom->name,
                'department' => $request->department,
                'qrcode' => $QrCode,
                'date' => Carbon::parse($request->start_date)->format('Y-m-d'),
                'time' => Carbon::parse($request->start_date)->format('H:i'),
                'organizer' => Auth::user()->name,

            ]);


            // return response()->json([
            //     'data' => $data
            // ]);


            // $getSendMail = json_decode($request->participant);
            // $getSendMail = explode(",", $request->participant);
            // $roomTitle = $request->title;
            // foreach ($sendMail as $mail) {
            //     Mail::to($mail)->send(new AddMailToMeeting($data));
            // }

            // $getSendMail = $request->participant;
            // dispatch(new SendMailJob($data, $getSendMail));

            // dispatch(new SendMailJob($data));


            // $getEmailList = $request->participant;
            // $getEmailList = json_decode($request->participant);

            $getEmailList = (explode(",", $request->participant));


            // $getEmailList = json_decode($getSendMail[0]);

            // return response()->json([
            //     'mail' => $getEmailList
            // ]);


            foreach ($getEmailList as $emailList) {
                $newParticipan = new Participant();
                $newParticipan->booking_id =  $newBooking->id;
                $newParticipan->email =  $emailList;
                $newParticipan->status_booking = 'waiting';
                $newParticipan->save();
                dispatch(new SendMailJob($data, $emailList));
            }





            // Mail::to('fauziagustian68@gmail.com')->send(new AddMailToMeeting($roomTitle));

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
