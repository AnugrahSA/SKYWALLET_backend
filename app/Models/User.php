<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama', 'username', 'password', 'aktif', 'date_created', 'email'];
}
