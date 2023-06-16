<?php

namespace App\Http\Controllers;
use App\Models\Keuangan;
use App\Helpers\Validation;
use App\Helpers\Generator;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
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
        try{
            $validator = Validation::getValidateKeuangan($request);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $user_id = $request->user()->id;

                $csl = Keuangan::create([
                    'id' => Generator::getUUID(),
                    'type_keuangan' => $request->type_keuangan,
                    'nama_kategori' => $request->nama_kategori,
                    'deskripsi_keuangan' => $request->deskripsi_keuangan,
                    'jumlah_keuangan' => $request->jumlah_keuangan,
                    'created_at' => date("Y-m-d h:i:s"),
                    'id_user' => $user_id,
                    'updated_at' => null,
                    'tanggal_keuangan' => $request->tanggal_keuangan,
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'keuangan created',
                    'data' => $csl
                ], Response::HTTP_OK);
            }
        } catch(\Exception $err) {
            return response()->json([
                'status' => 'error',
                'message' => $err->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function count_total(Request $request)
    {
        try {
            $user_id = $request -> user() -> id;
            $keuangan = DB::select(DB::raw("SELECT 
            total.total,
            pemasukan.pemasukan,
            pengeluaran.pengeluaran
          FROM
            (SELECT COALESCE(SUM(jumlah_keuangan),0) AS pengeluaran FROM keuangan WHERE type_keuangan = 'pengeluaran' AND id_user = '".$user_id."') AS pengeluaran,
            (SELECT COALESCE(SUM(jumlah_keuangan), 0) AS total FROM keuangan WHERE id_user = '".$user_id."') AS total,
            (SELECT COALESCE(SUM(jumlah_keuangan), 0) AS pemasukan FROM keuangan WHERE type_keuangan = 'pemasukan' AND id_user = '".$user_id."') AS pemasukan"));
                
                return response()->json([
                     'status' => 'Success',
                     'data' => $keuangan,
                     'result' => 'data tidak ditemukan'
                 ], Response::HTTP_OK);

         } catch (\Exception $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => $e->getMessage()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

    public function count_history(Request $request)
    {
        try {
            $user_id = $request -> user() -> id;
            $keuangan = Keuangan::selectRaw("id, type_keuangan, nama_kategori, deskripsi_keuangan, jumlah_keuangan, tanggal_keuangan, created_at")
            -> where("id_user",$user_id)
            -> orderBy("tanggal_keuangan","desc")
            -> orderBy("created_at","desc")
            -> get();
                
                return response()->json([
                     'status' => 'Success',
                     'data' => $keuangan,
                     'result' => 'data tidak ditemukan'
                 ], Response::HTTP_OK);

         } catch (\Exception $e) {
             return response()->json([
                 'status' => 'error',
                 'message' => $e->getMessage()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
    }

    public function getTotalKeuanganbyMonth(Request $request, $year, $type){
        try{
            $user_id = $request->user()->id;

            $pym = Keuangan::selectRaw('MONTH(created_at) as context, SUM(jumlah_keuangan) as total')
                ->groupBy('context')
                ->where('id_user', $user_id)
                ->where('type_keuangan', $type)
                ->whereRaw('YEAR(created_at) = '.$year)
                ->orderBy('context','ASC')
                ->get();

            $obj = [];
            for ($i = 1; $i <= 12; $i++) {
                $spend = 0;
                $timestamp = mktime(0, 0, 0, $i, 1, date('Y'));
                $mon = date('M', $timestamp);
            
                foreach ($pym as $cs) {
                    if ($cs->context == $i) {
                        $spend = $cs->total;
                        break;
                    }
                }
            
                $obj[] = [
                    'context' => $mon,
                    'total' => (int)$spend,
                ];
            }

            $collection = collect($obj);

            return response()->json([
                'status' => 'success',
                'message' => "Data keuangan berhasil diambil", 
                'data' => $collection
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalKeuanganbyDay(Request $request, $month, $year, $type){
        try{
            $user_id = $request->user()->id;

            $pym = Keuangan::selectRaw('DAY(created_at) as context, SUM(jumlah_keuangan) as total')
                ->groupBy('context')
                ->where('id_user', $user_id)
                ->where('type_keuangan', $type)
                ->whereRaw('YEAR(created_at) = '.$year)
                ->whereRaw('MONTH(created_at) = '.$month)
                ->orderBy('context','ASC')
                ->get();

            $obj = [];
            $date = $year."-".$month."-01";
            $max = date("t", strtotime($date));

            for ($i = 1; $i <= $max; $i++) {
                $spend = 0;
            
                foreach ($pym as $cs) {
                    if ($cs->context == $i) {
                        $spend = $cs->total;
                        break;
                    }
                }
            
                $obj[] = [
                    'context' => (string)$i,
                    'total' => (int)$spend,
                ];
            }

            $collection = collect($obj);

            return response()->json([
                'status' => 'success',
                'message' => "Analytic data retrived", 
                'data' => $collection
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
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
