<?php

namespace App\Livewire;

use App\Models\ListadePrecios;
use Livewire\Component;
use Illuminate\Support\Carbon;

class TablaPreciosActuales extends Component
{
    public function render()
    {
        $empresaId = session('empresa_id');
        $fiveDaysAgo = Carbon::now()->subDays(5);

        $precios = ListadePrecios::where('id_empresa', $empresaId)
            ->where('updated_at', '>', $fiveDaysAgo)
            ->orderByDesc('updated_at')
            ->get();

        return view('livewire.tabla-precios-actuales', compact('precios'));
    }
}
