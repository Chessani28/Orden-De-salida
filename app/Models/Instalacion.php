<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    use HasFactory;


    protected $table = "instalacion";
    protected $fillable = [
        'id_programacion',
        'id_venta',
        'img',
        'status',

    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_users');
}
}
