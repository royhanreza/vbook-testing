<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchRoomUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;

        if ($companyId == null) {
            return view('user.booking.guest');
        } else {
            $req_search = $request->query('search');
            $projector = $request->query('projector');
            $internet = $request->query('internet');
            $capacity = $request->query('capacity');

            $roomQuery = Room::with(['bookingRoom'])->where('company_id', $companyId);

            if ($req_search !== null) {
                $roomQuery->where('name', 'LIKE', "%{$req_search}%");
            }

            if ($internet !== null) {
                $roomQuery->where('internet', $internet);
            }

            if ($projector !== null) {
                $roomQuery->where('projector', $projector);
            }

            // if ($capacity !== null) {
            //     $roomQuery->where('capacity', '>=', $capacity);
            // }
            if ($capacity !== null) {
                if ($capacity == 10) {
                    $roomQuery->whereBetween('capacity', [0, $capacity]);
                }
                if ($capacity == 20) {
                    $roomQuery->whereBetween('capacity', [10, $capacity]);
                }
                if ($capacity == 30) {
                    $roomQuery->whereBetween('capacity', [20, $capacity]);
                }
                if ($capacity == 50) {
                    $roomQuery->whereBetween('capacity', [30, $capacity]);
                }
                if ($capacity == 51) {
                    $roomQuery->where('capacity', '>', $capacity);
                }
            }


            $rooms = $roomQuery->orderBy('id', 'DESC')->paginate(6);
            $rooms->withQueryString();
            // return $rooms;

            $currentPage = $rooms->currentPage();
            $currentUrl = "/search?page=" . $currentPage;
            $prevPage = $rooms->previousPageUrl();
            $nextPage = $rooms->nextPageUrl();
            $next2Page = $currentPage + 2;
            $prev2Page = $currentPage - 2;
            $next2Url = "/search?page=" . $next2Page;
            $prev2Url = "/search?page=" . $prev2Page;
            $lastPage = $rooms->lastPage();
            $totalItem = $rooms->total();
            // return $rooms;
            return view('user.booking.search', [
                'rooms' => $rooms,
                'internet' => $internet,
                'projector' => $projector,
                'capacity' => $capacity,
                'currentPage' => $currentPage,
                'currentUrl' => $currentUrl,
                'prevPage' => $prevPage,
                'nextPage' => $nextPage,
                'next2Page' => $next2Page,
                'prev2Page' => $prev2Page,
                'next2Url' => $next2Url,
                'prev2Url' => $prev2Url,
                'lastPage' => $lastPage,
                'totalItem' => $totalItem,
                'req_search' => $req_search,
            ]);
        }
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
