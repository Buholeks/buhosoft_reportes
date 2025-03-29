<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Vendedores;

class Equipo extends Model
{
    // use HasFactory;

    protected $table = 'tablaequipos'; // Nombre real de tu tabla en MySQL

    protected $fillable = [
        'folio_empresa',
        'folio_sucursal',
        'imei',
        'marca',
        'tipoeq',
        'tipove',
        'precio',
        'enganche',
        'numero',
        'id_vendedor',
        'id_user',
        'id_empresa',
        'id_sucursal',
    ];

    public $timestamps = true; // Desactiva si no tienes `created_at` y `updated_at`



    // Relación con Vendedor
    public function vendedores()
    {
        return $this->belongsTo(Vendedores::class, 'id_vendedor');
    }

    // Relación con Sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function tipoproducto()
    {
        return $this->belongsTo(Tipoproducto::class, 'tipoeq');
    }
    public function metodopago()
    {
        return $this->belongsTo(Metodopago::class, 'tipove');
    }
}
