<?php
// app/Models/Precio.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListadePrecios extends Model
{
    protected $table = 'listadeprecios';

    // Define los campos que se pueden llenar
    protected $fillable = [
        'descripcion',
        'tipoe',
        'tipove',
        'precio',
        'precio_promocion'
    ];


    // Listadeprecios.php
    public function tipoproducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipoe');
    }

    public function metodopago()
    {
        return $this->belongsTo(MetodoPago::class, 'tipove');
    }
}
