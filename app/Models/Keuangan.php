<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'keuangan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'id_user', 'type_keuangan', 'nama_kategori', 'deskripsi_keuangan', 'jumlah_keuangan', 'tanggal_keuangan', 'created_at', 'updated_at'];
}
