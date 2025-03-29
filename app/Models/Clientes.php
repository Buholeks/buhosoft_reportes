<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = ['nombre', 'correo', 'telefono'];



    public $timestamps = true; // Desactiva si no tienes `created_at` y `updated_at`



}
