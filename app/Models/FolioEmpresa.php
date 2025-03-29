<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolioEmpresa extends Model
{
    protected $table = 'folios_empresas';

    protected $fillable = [
        'empresa_id',
        'ultimo_folio',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
