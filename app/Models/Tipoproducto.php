<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipoproducto extends Model
{
   // Especifica el nombre de la tabla si no sigue la convención (plural del nombre del modelo)
   protected $table = 'tabla_tipoproducto';

   // Define los campos que se pueden asignar de forma masiva
   protected $fillable = ['nombre'];

   // Si tu tabla no tiene columnas 'created_at' y 'updated_at', desactiva los timestamps
//    public $timestamps = false;
}
