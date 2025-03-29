<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chip;
use Carbon\Carbon;
class ControladorChip extends Controller
{
    public function metodoChip()
    {
        return view('local.chip');
    }


    public function guardarChip(Request $request)
    {

        // Validar los datos
        $request->validate([
            'iccid' => 'required|max:20',
            'numero' => 'required|max:255',
            'id_vendedor' => 'required',
        ]);


        // Obtener datos de la sesión
        $userId = session('user_id');
        $empresaId = session('empresa_id');
        $sucursalId = session('sucursal_id');

        // Guardar los datos en la base de datos
        Chip::create([
            'iccid' => $request->iccid,
            'numero' => $request->numero,
            'id_vendedor' => $request->id_vendedor,
            'id_user' => $userId, // Añadir el ID del usuario desde la sesión
            'id_empresa' => $empresaId, // Añadir el ID de la empresa desde la sesión
            'id_sucursal' => $sucursalId, // Añadir el ID de la sucursal desde la sesión
        ]);

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Registrado Correctamente.');
    }

    public function mostrarChip()
    {
        $mesActual = Carbon::now()->month; // Obtiene el mes actual
        $anioActual = Carbon::now()->year; // Obtiene el año actual

        $sucursalId = session('sucursal_id');
        // $empresaId = session('empresa_id');

        $Chip = Chip::with(['vendedores'])
            ->where('id_sucursal', $sucursalId)
            ->whereMonth('created_at', $mesActual)
            ->whereYear('created_at', $anioActual)
            ->orderBy('idtablachip', 'desc')
            ->get();

        return view('local.chip', compact('Chip'));
    }
}