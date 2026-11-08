<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'judul_ide',
        'deskripsi',
        'status',
    ];
}
