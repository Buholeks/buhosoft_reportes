<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model

{
    // use HasFactory;

    protected $table = 'garantia';
    protected $primaryKey = 'idtablagarantia'; // Especificar la clave primaria
    protected $fillable = [
        'id_empresa',
        'id_sucursal',
        'id_empleado',
        'id_user',
        'id_cliente',
        'imei',
        'marca',
        'fallo',
        'accesorios',
        'solucion',
    ];
    public $timestamps = true; // Desactiva si no tienes `created_at` y `updated_at`




    // Relación con Vendedor
    public function vendedores()
    {
        return $this->belongsTo(Vendedores::class, 'id_vendedor');
    }

    // Relación con clientes
    public function Clientes()
    {
        return $this->belongsTo(Clientes::class, 'id_cliente');
    }
    // Relación con sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }
    // Relación con historial
    public function historial()
{
    return $this->hasMany(HistorialGarantia::class, 'garantia_id', 'idtablagarantia');
}

}
