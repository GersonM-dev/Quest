<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'title',
        'deskripsi',
        'date',
        'file_path',
    ];
}
