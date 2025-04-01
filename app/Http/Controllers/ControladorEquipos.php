<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Sucursal;
use App\Models\Empresa;
use App\Models\Tipoproducto;
use App\Models\Metodopago;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EquiposExport;
use App\Models\ListadePrecios;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Arr;
use App\Http\Controllers\ControladorFolios;

class ControladorEquipos extends Controller
{
    // GET /equipos => equipos.index
    public function index(Request $request)
    {
        $empresaId = session('empresa_id');
    
        if (!$empresaId) {
            abort(403, 'No se ha definido la empresa actual.');
        }
    
        $sucursales = Sucursal::where('id_empresa', $empresaId)->get(); // 🔥 aquí está el ajuste
        $tiposEquipos = TipoProducto::all();
        $tiposVentas = MetodoPago::all();
    
        $equipos = collect();
    
        if (
            $request->filled('id_sucursal') ||
            $request->filled('tipoeq') ||
            $request->filled('tipove') ||
            $request->filled('imei') ||
            ($request->filled('fecha_inicio') && $request->filled('fecha_fin'))
        ) {
            $query = Equipo::query()->where('id_empresa', $empresaId);
    
            if ($request->filled('id_sucursal')) {
                $query->where('id_sucursal', $request->id_sucursal);
            }
            if ($request->filled('tipoeq')) {
                $query->where('tipoeq', $request->tipoeq);
            }
            if ($request->filled('tipove')) {
                $query->where('tipove', $request->tipove);
            }
            if ($request->filled('imei')) {
                $query->where('imei', 'LIKE', "%{$request->imei}%");
            }
            if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
                $fechaInicio = Carbon::parse($request->fecha_inicio)->startOfDay();
                $fechaFin = Carbon::parse($request->fecha_fin)->endOfDay();
                $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
            }
    
            $equipos = $query->get();
        }
    
        return view('equipos.index', compact('sucursales', 'tiposEquipos', 'tiposVentas', 'equipos'));
    }
    

    // GET /equipos/create => equipos.create
    public function create()
    {
        $mesActual = Carbon::now()->month;
        $anioActual = Carbon::now()->year;

        $sucursalId = session('sucursal_id');
        $empresaId = session('empresa_id');

        $equipos = Equipo::with(['vendedores', 'tipoproducto', 'metodopago', 'sucursal'])
            ->where('id_sucursal', $sucursalId)
            ->whereMonth('created_at', $mesActual)
            ->whereYear('created_at', $anioActual)
            ->orderBy('id', 'desc')
            ->get();


        $fiveDaysAgo = Carbon::now()->subDays(5);
        $precios = ListadePrecios::where('id_empresa', $empresaId)
            ->where('updated_at', '>', $fiveDaysAgo)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('equipos.registro', compact('equipos', 'precios'));
    }

    // POST /equipos => equipos.store
    public function store(Request $request)
    {
        $empresaId = session('empresa_id');
        $sucursalId = session('sucursal_id');
        $userId = session('user_id');

        // ✅ Primero validamos
        $request->validate([
            'imei' => 'required|max:20|unique:tablaequipos,imei',
            'marca' => 'required|max:255',
            'tipoeq' => 'required|max:255',
            'tipove' => 'max:255',
            'precio' => 'required',
            'numero' => 'required|string|max:20',
            'id_vendedor' => 'required',
        ], [
            'imei.unique' => 'El IMEI ya se encuentra registrado en el sistema.',
            'imei.required' => 'El campo IMEI es obligatorio.',
        ]);

        // ✅ Solo si pasa la validación generamos folios
        $folios = ControladorFolios::generar($empresaId, $sucursalId);

        Equipo::create([
            'folio_empresa'  => $folios['folio_empresa'],
            'folio_sucursal' => $folios['folio_sucursal'],
            'imei' => $request->imei,
            'marca' => $request->marca,
            'tipoeq' => $request->tipoeq,
            'tipove' => $request->tipove,
            'precio' => $request->precio,
            'enganche' => $request->enganche,
            'numero' => $request->numero,
            'id_vendedor' => $request->id_vendedor,
            'id_user' => $userId,
            'id_empresa' => $empresaId,
            'id_sucursal' => $sucursalId,
        ]);

        return redirect()->route('equipos.create')->with([
            'mensaje' => 'Equipo registrado correctamente.',
            'tipo' => 'creado'
        ]);
    }


    // GET /equipos/{equipo}/edit => equipos.edit
    public function edit($id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->created_at_formatted = optional($equipo->created_at)->format('Y-m-d');

        return response()->json($equipo);
    }

    // PUT /equipos/{equipo} => equipos.update
    public function update(Request $request, $id)
    {
        $request->validate([
            'imei' => 'required|string|max:255',
            'marca' => 'nullable|string|max:255',
            'precio' => 'nullable|numeric|min:0',
            'tipoeq' => 'nullable|exists:tabla_tipoproducto,id',
            'tipove' => 'nullable|exists:tabla_metodopagos,id',
            'id_sucursal' => 'nullable|exists:tablasucursal,id',
            'fecha' => 'nullable|date',
        ]);

        $equipo = Equipo::findOrFail($id);

        if ($request->filled('fecha')) {
            $equipo->created_at = Carbon::parse($request->fecha)->startOfDay();
        }

        $data = $request->all();
        $equipo->update(Arr::except($data, ['fecha']));

        // Al actualizar
        return back()->with([
            'mensaje' => 'Equipo actualizado correctamente.',
            'tipo' => 'actualizado'
        ]);
    }

    // DELETE /equipos/{equipo} => equipos.destroy
    public function destroy(Equipo $equipo)
    {
        $equipo->delete();

        // Si fue petición AJAX, devolvemos JSON
        if (request()->expectsJson()) {
            return response()->json(['mensaje' => 'Equipo eliminado correctamente.'], 200);
        }

        // Si fue petición normal (formulario), redireccionamos
        return redirect()->back()->with([
            'mensaje' => 'Equipo eliminado correctamente.',
            'tipo' => 'eliminado'
        ]);
    }


    // POST /equipos/seleccionados => equipos.seleccionados
    public function procesarSeleccionados(Request $request)
    {
        $equiposIds = $request->input('equipos_seleccionados', []);
        if (!empty($equiposIds)) {
            Equipo::whereIn('id', $equiposIds)->delete();
            return redirect()->back()->with(
                [
                    'mensaje' => 'Los Seleccionados se Eliminaron Correctamente',
                    'tipo' => 'eliminado'
                ]
            );
        }

        return redirect()->back()->with('error', 'No seleccionaste ningún equipo.');
    }

    // POST /equipos/export/excel => equipos.export.excel
    public function exportExcel(Request $request)
    {
        $equiposIds = json_decode($request->equipos_seleccionados ?? '[]', true);

        if (empty($equiposIds)) {
            return redirect()->back()->with('error', 'No seleccionaste ningún equipo.');
        }

        return Excel::download(new EquiposExport($equiposIds), 'equipos.xlsx');
    }

    // POST /equipos/export/pdf => equipos.export.pdf
    public function exportPDF(Request $request)
    {
        $equiposIds = json_decode($request->equipos_seleccionados ?? '[]', true);

        if (empty($equiposIds)) {
            return redirect()->back()->with('error', 'No seleccionaste ningún equipo.');
        }

        $equipos = Equipo::whereIn('id', $equiposIds)->get();

        // Aquí obtenemos empresa y sucursal desde la sesión y el usuario
        $empresa = empresa::find(session('empresa_id'));
        $sucursal = Sucursal::find(session('sucursal_id'));

        // Generamos el PDF con orientación vertical (portrait)
        $pdf = Pdf::loadView('exports.equipos_pdf', compact('equipos', 'empresa', 'sucursal'))
            ->setPaper('letter', 'landscape');

        return $pdf->download('equipos.pdf');
    }
}
