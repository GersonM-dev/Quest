<?php

// app/Models/Leaderboard.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    protected $fillable = ['user_id', 'score', 'badge'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
