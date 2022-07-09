<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuTab extends Model
{
    use HasFactory;
    protected $fillable = [
        'usuario_id',
        'tablero_id',
    ];
}
