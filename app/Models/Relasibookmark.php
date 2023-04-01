<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relasibookmark extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'relasibookmark';
    protected $primaryKey = 'id';
    protected $fillable = ['idbookmark', 'iduser', 'isiberita', 'createdat'];
    protected $casts = [
        'isiberita' => 'array'
    ];
}
