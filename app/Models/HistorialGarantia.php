<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistorialGarantia extends Model
{
    protected $fillable = ['garantia_id', 'estado_anterior', 'estado_nuevo', 'user_id'];

    public function garantia()
    {
        return $this->belongsTo(Garantia::class, 'garantia_id');
    }
    

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function actualizarEstado(Request $request, Garantia $garantia)
    {
        $estadoAnterior = $garantia->estado;
        $nuevoEstado = $request->input('estado');

        if ($estadoAnterior !== $nuevoEstado) {
            $garantia->estado = $nuevoEstado;
            $garantia->save();

            HistorialGarantia::create([
                'garantia_id' => $garantia->idtablagarantia,
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $nuevoEstado,
              'user_id' => Auth::user()->id,


            ]);
        }

        return back()->with('success', 'Estado actualizado y registrado en el historial.');
    }
}
