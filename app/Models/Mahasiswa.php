<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nrp',
        'nama',
        'email',
        'jurusan',
        'angkatan',
        'ipk',
        'status',
    ];

    protected $casts = [
        'angkatan' => 'integer',
        'ipk' => 'float',
    ];
}
