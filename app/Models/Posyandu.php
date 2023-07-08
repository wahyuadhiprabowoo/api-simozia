<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posyandu extends Model
{
     protected $table = 'posyandu';

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function balita()
    {
        return $this->hasMany(Balita::class);
    }
}
