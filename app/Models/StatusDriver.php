<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusDriver extends Model
{
    use HasFactory;

    protected $fillable = [
        'drivers_id', 'status_id'
    ];
}
