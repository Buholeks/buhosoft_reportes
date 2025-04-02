<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vendedores;
use App\Models\Sucursal;
use Carbon\Carbon;

class ControladorComision extends Controller
{
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');
        $datos = []; // Por defecto, sin datos
    
        // Solo consultar si hay algún filtro aplicado
        if ($request->hasAny(['mes', 'id_sucursal', 'id_vendedor', 'comision_mayor', 'comision_menor'])) {
    
            $mes = $request->input('mes') ? Carbon::parse($request->input('mes'))->month : now()->month;
            $anio = $request->input('mes') ? Carbon::parse($request->input('mes'))->year : now()->year;
    
            $comisionMayor = $request->input('comision_mayor', 30);
            $comisionMenor = $request->input('comision_menor', 20);
    
            $sucursal = $request->input('id_sucursal');
            $vendedor = $request->input('id_vendedor');
    
            $query = DB::table('tablaequipos')
                ->join('tablaempleados', 'tablaequipos.id_vendedor', '=', 'tablaempleados.id')
                ->select(
                    'tablaequipos.id_vendedor',
                    'tablaempleados.nombre as vendedor',
                    DB::raw('SUM(tablaequipos.precio) as total_ventas'),
                    DB::raw('COUNT(*) as total_equipos')
                )
                ->where('tablaequipos.id_empresa', $empresaId)
                ->whereMonth('tablaequipos.created_at', $mes)
                ->whereYear('tablaequipos.created_at', $anio)
                ->when($sucursal, fn($q) => $q->where('tablaequipos.id_sucursal', $sucursal))
                ->when($vendedor, fn($q) => $q->where('tablaequipos.id_vendedor', $vendedor))
                ->groupBy('tablaequipos.id_vendedor', 'tablaempleados.nombre')
                ->get();
    
            foreach ($query as $row) {
                $detalle = DB::table('tablaequipos')
                    ->where('id_empresa', $empresaId)
                    ->where('id_vendedor', $row->id_vendedor)
                    ->whereMonth('created_at', $mes)
                    ->whereYear('created_at', $anio)
                    ->when($sucursal, fn($q) => $q->where('id_sucursal', $sucursal))
                    ->get();
    
                $comision_total = $detalle->sum(function ($venta) use ($comisionMayor, $comisionMenor) {
                    return $venta->precio >= 1000 ? $comisionMayor : $comisionMenor;
                });
    
                $datos[] = [
                    'vendedor' => $row->vendedor,
                    'total_ventas' => $row->total_ventas,
                    'total_equipos' => $row->total_equipos,
                    'total_comision' => $comision_total,
                    'detalle' => $detalle,
                ];
            }
    
        } else {
            // Definí variables por defecto para evitar errores en la vista
            $mes = null;
            $anio = null;
            $comisionMayor = 30;
            $comisionMenor = 20;
        }
    
        $vendedores = Vendedores::where('id_empresa', $empresaId)->get();
        $sucursales = Sucursal::where('id_empresa', $empresaId)->get();
    
        return view('comisiones.index', compact('datos', 'vendedores', 'sucursales', 'mes', 'anio', 'comisionMayor', 'comisionMenor'));
    }
    
}
