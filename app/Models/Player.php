<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    public function getNameAttribute()
    {
        return $this->attributes['last_name'] . ' ' . $this->attributes['first_name'];
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
