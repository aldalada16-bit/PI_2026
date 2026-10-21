<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kost extends Model
{
    use HasFactory;

    protected $table = 'kost';
    protected $primaryKey = 'id_kost';

    protected $fillable = [
        'id_pengguna',
        'nama_kost',
        'alamat',
        'deskripsi',
        'foto_kost',
        'fasilitas',
    ];
}