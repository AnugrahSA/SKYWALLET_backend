<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
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
    public function getAlluser()
    {
        try {
            $user = User::select("*")
                ->orderBy('date_created','DESC')
                ->get();

            if($user->isEmpty()){
                return response()->json([
                    'status' => 'Success',
                    'data' => null,
                    'message' => 'data tidak ditemukan'
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status' => 'Success',
                    'data' => $user,
                    'message' => 'data ditemukan'
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserbyid($id)
    {
        try {
            $user = User::select("*")
                ->orderBy('date_created','DESC')
                ->where('id',$id)
                ->get();

            if($user->isEmpty()){
                return response()->json([
                    'status' => 'Success',
                    'data' => null,
                    'message' => 'data tidak ditemukan'
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status' => 'Success',
                    'data' => $user,
                    'message' => 'data ditemukan'
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function adduser(Request $request)
    {
        try {
            $user = User::create([
                'nama' => $request->nama, 
                'username'=> $request->username,
                'password' => $request->password, 
                'aktif'=> 1,
                'date_created'=> date('Y-m-d h:i:s')
            ]);
            return response()->json([
                'status' => 'Success',
                'data' => $user,
                'message' => 'data ditemukan'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
