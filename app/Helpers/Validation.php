<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Validator;

class Validation
{
    public static function getValidateLogin($request){ 
        return Validator::make($request->all(), [
            'email' => 'required|min:6|max:75|string',
            'password' => 'required|min:6|max:30|string'
        ]);
    }

    public static function getValidateRegister($request){ 
        return Validator::make($request->all(), [
            'nama' => 'required|min:6|max:100|string',
            'username' => 'required|min:6|max:100|string',
            'email' => 'required|min:6|max:75|string',
            'password' => 'required|min:6|max:30|string'
        ]);
    }

    public static function getValidateKeuangan($request){ 
        return Validator::make($request->all(), [
            'type_keuangan' => 'required|min:3|max:20|string',
            'nama_kategori' => 'required|min:3|max:35|string',
            'deskripsi_keuangan' => 'required|min:6|max:60|string',
            'jumlah_keuangan' => 'required|min:500|max:10000000|numeric',
            'tanggal_keuangan' => 'required|date_format:Y-m-d'
        ]);
    }
}
