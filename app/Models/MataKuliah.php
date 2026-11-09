<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama_mk',
        'sks',
        'semester',
        'dosen_pengampu',
    ];

    protected $casts = [
        'sks' => 'integer',
        'semester' => 'integer',
    ];
}
