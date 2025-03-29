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

    public function showSelectSucursal(Request $request)
    {
        $sucursales = $request->session()->get('sucursales');
        return view('select_sucursal', compact('sucursales'));
    }

    public function selectSucursal(Request $request)
    {
        $sucursal = Sucursal::find($request->sucursal_id);
        if (!$sucursal) {
            return redirect()->back()->with('error', 'Sucursal no válida');
        }

        session([
            'sucursal_id' => $sucursal->id,
            'empresa_id'  => $sucursal->id_empresa
        ]);

        return redirect()->route('home');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
