<?php

namespace App\Http\Controllers;

use App\Models\Garantia;
use App\Models\HistorialGarantia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ControladorGarantia extends Controller
{
    // GET /garantias
    public function index()
    {
        $anioActual = Carbon::now()->year;
        $sucursalId = session('sucursal_id');

        $garantias = Garantia::with(['vendedores', 'clientes'])
            ->where('id_sucursal', $sucursalId)
            ->whereYear('created_at', $anioActual)
            ->orderBy('idtablagarantia', 'desc')
            ->get();

        return view('garantia.index', compact('garantias'));
    }

    // GET /garantias/create
    public function create()
    {
        return view('garantia.index');
    }

    // POST /garantias
    public function store(Request $request)
    {
        // Validar si el IMEI ya existe
        $existeImei = Garantia::where('imei', $request->imei)->exists();
        if ($existeImei) {
            return redirect()->back()->with('error', 'El IMEI ya está registrado.');
        }

        // Validar los datos
        $request->validate([
            'imei' => 'required|max:20',
            'marca' => 'required|max:255',
            'fallo' => 'required|max:255',
            'accesorios' => 'max:255',
        ]);

        // Datos de sesión
        $userId = session('user_id');
        $empresaId = session('empresa_id');
        $sucursalId = session('sucursal_id');

        Garantia::create([
            'imei' => $request->imei,
            'marca' => $request->marca,
            'fallo' => $request->fallo,
            'accesorios' => $request->accesorios,
            'id_cliente' => $request->id_cliente,
            'id_empleado' => $request->id_vendedor,
            'id_user' => $userId,
            'id_empresa' => $empresaId,
            'id_sucursal' => $sucursalId,
        ]);

        return redirect()->back()->with('success', 'Registrado Correctamente.');
    }

    // GET /garantias/{id}
    public function show($id)
    {
        $garantia = Garantia::findOrFail($id);
        return view('garantia.show', compact('garantia'));
    }

    // GET /garantias/{id}/edit
    public function edit($id)
    {
        $garantia = Garantia::findOrFail($id);
        return view('garantia.edit', compact('garantia'));
    }

    // PUT /garantias/{id}
    public function update(Request $request, $id)
    {
        $garantia = Garantia::findOrFail($id);

        // Validar los datos
        $request->validate([
            'imei' => 'required|max:20|unique:garantias,imei,' . $id . ',idtablagarantia',
            'marca' => 'required|max:255',
            'fallo' => 'required|max:255',
            'accesorios' => 'max:255',
        ]);

        // Actualizar los datos
        $garantia->update([
            'imei' => $request->imei,
            'marca' => $request->marca,
            'fallo' => $request->fallo,
            'accesorios' => $request->accesorios,
            'id_cliente' => $request->id_cliente,
            'id_empleado' => $request->id_vendedor,
        ]);

        return redirect()->route('garantia.index')->with('success', 'Garantía actualizada correctamente.');
    }

    // DELETE /garantias/{id}
    public function destroy($id)
    {
        $garantia = Garantia::findOrFail($id);
        $garantia->delete();      // Si fue petición AJAX, devolvemos JSON

        if (request()->expectsJson()) {
            return response()->json(['mensaje' => 'Garantia eliminado correctamente.'], 200);
        }

        // Si fue petición normal (formulario), redireccionamos
        return redirect()->back()->with([
            'mensaje' => 'Garantia eliminado correctamente.',
            'tipo' => 'eliminado'
        ]);
    }


    public function verStatus()
    {
        $empresaId = session('empresa_id');

        $garantias = Garantia::whereHas('sucursal', function ($query) use ($empresaId) {
            $query->where('id_empresa', $empresaId);
        })->with(['clientes', 'sucursal'])->get();

        return view('garantia.status', compact('garantias'));
    }

    public function cambiarStatus(Request $request, $id)
    {
        $garantia = Garantia::findOrFail($id);

        $estadoAnterior = $garantia->estado;
        $estadoNuevo = $request->input('estado');

        if ($estadoAnterior !== $estadoNuevo) {
            $garantia->estado = $estadoNuevo;
            $garantia->save();

            // Registrar el cambio en historial
            HistorialGarantia::create([
                'garantia_id' => $garantia->idtablagarantia, // Tu campo de clave primaria personalizado
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $estadoNuevo,
                'user_id' => session('user_id'),
            ]);
        }

        return response()->json(['success' => true, 'nuevo_estado' => $estadoNuevo]);
    }
}
