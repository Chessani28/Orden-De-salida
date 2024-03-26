<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $fillable = ['nombre', 'ine', 'luz','ubicacion', 'pago', 'status', 'tipo'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
