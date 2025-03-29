<?php

namespace App\Livewire;

use App\Models\Equipo;
use Livewire\Component;
use Illuminate\Support\Carbon;

class TablaEquiposLocales extends Component
{
    protected $listeners = ['equipoRegistrado' => '$refresh'];

    public function render()
    {
        $mesActual = now()->month;
        $anioActual = now()->year;
        $sucursalId = session('sucursal_id');

        $equipos = Equipo::with(['vendedores', 'tipoproducto', 'metodopago'])
            ->where('id_sucursal', $sucursalId)
            ->whereMonth('created_at', $mesActual)
            ->whereYear('created_at', $anioActual)
            ->orderByDesc('id')
            ->get();

        return view('livewire.tabla-equipos-locales', compact('equipos'));
    }
}
