<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Empresa extends Model
{
    use Notifiable;

    protected $table = 'tablaempresas';

    protected $fillable = ['id','nom_empresa'];
}
