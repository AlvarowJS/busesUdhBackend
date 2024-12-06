<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buse extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'placa',
        'activo',
        'driver_id',
        'statu_id',
    ];
}
