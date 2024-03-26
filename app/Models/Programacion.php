<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;
    protected $table = "programacion";
    protected $fillable = [
        'id_venta',
        'fecha_termino',
        'fecha_instalacion',
        'status',
        'id_users',
    ];

    public function venta()
{
    return $this->belongsTo(Venta::class, 'id_venta');
}

public function instalaciones() {
    return $this->hasMany(Instalacion::class, 'id_programacion');
}

public function instalacion()
{
    return $this->belongsTo(Instalacion::class, 'instalacion_id');
}
public function users()
{
    return $this->belongsTo(User::class, 'id_users');
}
}
