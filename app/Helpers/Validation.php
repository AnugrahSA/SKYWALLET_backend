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
}