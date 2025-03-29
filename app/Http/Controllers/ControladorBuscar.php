<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendedores; // Reemplaza con tu modelo
use App\Models\Clientes;
class ControladorBuscar extends Controller
{
    public function buscarVendedores(Request $request)
    {
        $empresaId = session('empresa_id');

        $term = $request->get('term');
        $results = vendedores::where('id_empresa', $empresaId)
        ->where('nombre', 'LIKE', '%' . $term . '%')
        ->get(['id', 'nombre']); // Obtén el ID y el nombre

        return response()->json($results);
    }

    public function buscarClientes(Request $request)
    {
        $empresaId = session('empresa_id');

        $term = $request->get('term');
        $results = clientes::where('id_empresa', $empresaId)
        ->where('nombre', 'LIKE', '%' . $term . '%')
        ->get(['id', 'nombre']); // Obtén el ID y el nombre

        return response()->json($results);
    }
}
