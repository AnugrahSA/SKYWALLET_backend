<?php

namespace App\Http\Controllers;
use App\Models\Relasibookmark;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class RelasibookmarkController extends Controller
{
    public function getisibookmark($id)
    {
        try {
           $bookmark = Relasibookmark::select("*")
                ->orderBy('createdat','DESC')
                ->get();

            if($bookmark->isEmpty()){
                return response()->json([
                    'status' => 'Success',
                    'data' => null,
                    'message' => 'data tidak ditemukan'
                ], Response::HTTP_OK);
            }else{
                return response()->json([
                    'status' => 'Success',
                    'data' =>$bookmark,
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
}
