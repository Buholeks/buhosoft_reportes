<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class sucursal extends Model
{
    use HasFactory;

    protected $table = 'tablasucursal'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'id_empresa',
        'nombre',
        'direccion',
        'numero_tel',
        'prefijo_folio_sucursal'

    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
