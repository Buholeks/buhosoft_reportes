<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\MetodoPago;
use App\Models\Sucursal;
use App\Models\TipoProducto;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class TablaAdmin extends Component
{
    use WithPagination;

    public string $id_sucursal = '';
    public string $tipoeq = '';
    public string $tipove = '';
    public string $imei = '';
    public string $fecha_inicio;
    public string $fecha_fin;

    public array $seleccionados = [];
    public bool $selectAll = false;

    public function mount()
    {
        $this->fecha_inicio = now()->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->seleccionados = $this->getEquiposProperty()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->seleccionados = [];
        }
    }

    public function exportar(string $tipo)
    {
        if (empty($this->seleccionados)) {
            $this->dispatch('alerta', [
                'tipo' => 'warning',
                'mensaje' => 'Selecciona al menos un equipo para exportar.'
            ]);
            return;
        }

        session()->put('equipos_seleccionados', $this->seleccionados);

        return redirect()->route($tipo === 'pdf' ? 'equipos.export.pdf' : 'equipos.export.excel');
    }

    public function eliminarSeleccionados()
    {
        if (empty($this->seleccionados)) {
            $this->dispatch('alerta', [
                'tipo' => 'warning',
                'mensaje' => 'Selecciona al menos un equipo para eliminar.'
            ]);
            return;
        }

        Equipo::whereIn('id', $this->seleccionados)->delete();
        $this->reset('seleccionados', 'selectAll');

        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Equipos eliminados correctamente.'
        ]);
    }

    public function getEquiposProperty()
    {
        $empresaId = session('empresa_id');

        return Equipo::with(['tipoproducto', 'metodopago', 'sucursal'])
            ->where('id_empresa', $empresaId)
            ->when($this->id_sucursal, fn($q) => $q->where('id_sucursal', $this->id_sucursal))
            ->when($this->tipoeq, fn($q) => $q->where('tipoeq', $this->tipoeq))
            ->when($this->tipove, fn($q) => $q->where('tipove', $this->tipove))
            ->when($this->imei, fn($q) => $q->where('imei', 'like', "%{$this->imei}%"))
            ->when($this->fecha_inicio && $this->fecha_fin, function ($q) {
                $inicio = Carbon::parse($this->fecha_inicio)->startOfDay();
                $fin = Carbon::parse($this->fecha_fin)->endOfDay();
                return $q->whereBetween('created_at', [$inicio, $fin]);
            })
            ->orderByDesc('created_at')
            ->paginate(15);
    }

    public function render()
    {
        return view('livewire.tabla-admin', [
            'equipos' => $this->equipos,
            'sucursales' => Sucursal::all(),
            'tiposEquipos' => TipoProducto::all(),
            'tiposVentas' => MetodoPago::all(),
        ]);
    }
}

