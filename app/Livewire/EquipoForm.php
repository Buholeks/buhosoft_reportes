<?php

namespace App\Livewire;

use App\Models\Equipo;
use App\Models\MetodoPago;
use App\Models\TipoProducto;
use App\Models\Vendedor;
use App\Http\Controllers\ControladorFolios;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class EquipoForm extends Component
{
    public $imei, $marca, $tipoeq, $tipove, $precio, $enganche, $numero, $id_vendedor;

    public function rules()
    {
        return [
            'imei' => 'required|max:20|unique:tablaequipos,imei',
            'marca' => 'required|max:255',
            'tipoeq' => 'required|max:255',
            'tipove' => 'nullable|max:255',
            'precio' => 'required|numeric',
            'numero' => 'required|string|max:20',
            'id_vendedor' => 'required|exists:tablavendedores,id',
        ];
    }

    public function registrarEquipo()
    {
        $this->validate();

        $empresaId = session('empresa_id');
        $sucursalId = session('sucursal_id');
        $userId = session('user_id');

        $folios = ControladorFolios::generar($empresaId, $sucursalId);

        Equipo::create([
            'folio_empresa'  => $folios['folio_empresa'],
            'folio_sucursal' => $folios['folio_sucursal'],
            'imei' => $this->imei,
            'marca' => $this->marca,
            'tipoeq' => $this->tipoeq,
            'tipove' => $this->tipove,
            'precio' => $this->precio,
            'enganche' => $this->enganche,
            'numero' => $this->numero,
            'id_vendedor' => $this->id_vendedor,
            'id_user' => $userId,
            'id_empresa' => $empresaId,
            'id_sucursal' => $sucursalId,
        ]);

        $this->reset();
        $this->dispatch('alerta', [
            'tipo' => 'success',
            'mensaje' => 'Equipo registrado correctamente.'
        ]);
    }

    public function render()
    {
        return view('livewire.equipo-form', [
            'tiposEquipos' => TipoProducto::all(),
            'tiposVentas' => MetodoPago::all(),
        ]);
    }
}
