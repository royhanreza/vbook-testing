<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ManageCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('company')->where('role_id', 2)->get();
        // return $user;
        return view('superadmin.manage-company.index', [
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
        return view('superadmin.manage-company.create');
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

            //create company
            $newCompany = new Company();
            $newCompany->name = $request->name;
            $newCompany->aplication_name = $request->aplication_name;
            //contoh upload logo
            $logo = $request->file('logo');
            $nama_logo =  $request->name . "_" . $request->logo_name;
            $logo->move('gambar/company', $nama_logo);
            $newCompany->logo = $nama_logo;
            $newCompany->save();


            $newUser = new User();
            $newUser->company_id = $newCompany->id;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->username = $request->email;
            $newUser->no_telp = $request->no_telp;
            $newUser->role_id = 2;
            $newUser->password = Hash::make($request->password);
            $newUser->save();



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
        try {

            $updateUser = User::find($id);
            $updateUser->name = $request->name;
            $updateUser->email = $request->email;
            $updateUser->role_id = $request->role_id;
            $updateUser->no_telp = $request->no_telp;
            $updateUser->save();

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }
    public function destroy($id)
    {
        $user = User::find($id);

        try {
            $user->delete();
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

    public function forceDelete($id)
    {
        User::where('id', $id)->withTrashed()->forceDelete();

        return redirect()->route('users.index', ['status' => 'archived']);
    }
}
