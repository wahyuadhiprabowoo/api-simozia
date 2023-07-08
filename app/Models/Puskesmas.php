<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puskesmas extends Model
{
   protected $table = 'puskesmas';
    protected $fillable = [
        'nama_puskesmas',
        'alamat',
        'telepon',
        'sws_wa'];
    public function posyandu()
    {
        return $this->hasMany(Posyandu::class);
    }
}
