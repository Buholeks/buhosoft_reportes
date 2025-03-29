<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chip extends Model
{
    protected $table = 'chip';

    // Define los campos que se pueden llenar
    protected $fillable = [
        'id_empresa',
        'id_sucursal',
        'id_user',
        'id_vendedor',
        'numero',
        'iccid',
    ];
    public $timestamps = false; // Desactiva si no tienes `created_at` y `updated_at`

       // Relación con Vendedor
   public function vendedores()
   {
       return $this->belongsTo(Vendedores::class, 'id_vendedor');
   }
}
