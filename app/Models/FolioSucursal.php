<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolioSucursal extends Model
{
    protected $table = 'folios_sucursales';

    protected $fillable = [
        'empresa_id',
        'sucursal_id',
        'ultimo_folio',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
