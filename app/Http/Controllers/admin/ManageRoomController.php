<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyDevice;
use App\Models\Device;
use App\Models\Division;
use App\Models\Room;
use App\Models\RoomRestrict;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ManageRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;
        $room = Room::with('user', 'device')->where('company_id', $companyId)->get();
        $user = User::with('room')->where('role_id', 4)->where('company_id', $companyId)->get();
        // return $user;
        return view('admin.manage-room.index', [
            'room' => $room,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;
        $device = CompanyDevice::with('device', 'company')->where('company_id', $companyId)->get();
        $division = Division::where('company_id', $companyId)->get();
        // return $device;
        return view('admin.manage-room.create', [
            'device' => $device,
            'division' => $division,
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

        try {
            // generate a pin based on 6 a random character
            $random = mt_rand(100000, 999999);

            // shuffle the result
            $pin = str_shuffle($random);
            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->company_id = Auth::user()->company_id;
            $newUser->email = str_replace(' ', '-', $request->name) . '@gmail.com';
            $newUser->username = str_replace(' ', '-', $request->name) . '@gmail.com';
            // return response()->json([
            //     'nama' => str_replace(' ', '-', $request->name) . '@gmail.com',
            // ]);

            $newUser->role_id = 4;
            $newUser->pin = $pin;
            $newUser->password = Hash::make(12345678);
            $newUser->save();

            $newRoom = new Room();
            $newRoom->user_id = $newUser->id;
            $newRoom->company_id = Auth::user()->company_id;
            $newRoom->name = $request->name;
            $newRoom->base_id = $request->base_id;
            $newRoom->calendar_id = $request->calendar_id;
            $newRoom->projector = $request->projector;
            $newRoom->internet = $request->internet;
            $newRoom->floor = $request->floor;
            $newRoom->capacity = $request->capacity;
            $newRoom->color_code = $request->color_code;
            $newRoom->ip_address = $request->ip_address;
            $newRoom->device_id = $request->device_id;
            $restrict = $request->isRestricionRoom;
            if ($restrict == 1) {
                $newRoom->restrict_room = 'yes';
            }
            $newRoom->save();

            $division = $request->divisionId;
            foreach ($division as $divisions) {
                $newRoomestrict = new RoomRestrict();
                $newRoomestrict->room_id = $newRoom->id;
                $newRoomestrict->company_id = Auth::user()->company_id;
                $newRoomestrict->division_id = $divisions;
                $newRoomestrict->save();
            }


            DB::commit();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
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
        $updateRoom = Room::find($id);

        $updateRoom->name = $request->name;
        $updateRoom->projector = $request->projector;
        $updateRoom->floor = $request->floor;
        $updateRoom->capacity = $request->capacity;
        $updateRoom->color_code = $request->color_code;
        $updateRoom->ip_address = $request->ip_address;
        $updateRoom->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        try {
            $room->delete();
            return [
                'message' => 'data has been deleted',
                'error' => false,
                'code' => 200,
            ];
        } catch (Exception $e) {
            return [
                'message' => 'internal error',
                'error' => true,
                'code' => 500,
                'errors' => $e,
            ];
        }
    }
}
