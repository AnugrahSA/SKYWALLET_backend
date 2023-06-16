<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Validation;
use Illuminate\Http\Response;
use App\Models\User;
use App\Helpers\Generator;

class RegisterController extends Controller
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
    public function create(Request $request)
    {
        try {
            $validator = Validation::getValidateRegister($request);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $check = User::select('username')->where('username',$request->username)->first();
                if($check==null){
                $user = User::create([
                    'id' => Generator::getUUID(),
                    'nama' => $request->nama, 
                    'username'=> $request->username,                    
                    'email'=> $request->email,
                    'password' => $request->password, 
                    'aktif'=> 1,
                    'date_created'=> date('Y-m-d h:i:s'),
                    
                ]);
                return response()->json([
                    'status' => 'Success',
                    'data' => $user,
                    'message' => 'Akun berhasil ditambahkan'
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username sudah pakai',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            }
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
