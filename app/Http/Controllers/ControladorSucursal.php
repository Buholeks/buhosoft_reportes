<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Empresa;
use Illuminate\Http\Request;

class controladorsucursal extends Controller
{
    public function showSelectSucursal(Request $request)
    {
        $sucursales = $request->session()->get('sucursales');
        return view('vista_sucursal', compact('sucursales'));
    }

    public function selectSucursal(Request $request)
    {
        $sucursal = Sucursal::find($request->sucursal_id);
        if (!$sucursal) {
            return redirect()->back()->with('error', 'Sucursal no válida');
        }

        session([
            'sucursal_id' => $sucursal->id,
            'empresa_id'  => $sucursal->id_empresa
        ]);

        return redirect()->route('home');
    }

    public function index()
    {
           $empresaId = session('empresa_id'); // Si solo quieres mostrar las de la empresa actual

        $sucursales = Sucursal::where('id_empresa', $empresaId)->get();

        return view('sucursales.index', compact('sucursales'));
    }
    public function create()
    {
        return view('sucursales.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:200',
            'direccion' => 'nullable|max:255',
            'numero_tel' => 'nullable|max:45',
        ]);

        // Obtener id_empresa desde la sesión

         $empresaId = session('empresa_id');
        if (!$empresaId) {
            return redirect()->back()->with('error', 'No se encontró una empresa activa en la sesión.');
        }

        Sucursal::create([
            'id_empresa' => $empresaId,
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'numero_tel' => $request->numero_tel,
        ]);

        return redirect()->route('sucursales.index')->with('success', 'Sucursal creada exitosamente.');
    }


    public function edit(Sucursal $sucursal)
    {
        return view('sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, Sucursal $sucursal)
    {
        $request->validate([
            'nombre' => 'required|max:200',
            'direccion' => 'nullable|max:255',
            'numero_tel' => 'nullable|max:45',
            'prefijo_folio_sucursal' => 'nullable|max:10',
        ]);

        $sucursal->update($request->all());
        return redirect()->route('sucursales.index')->with('success', 'Sucursal actualizada.');
    }

    public function destroy(Sucursal $sucursal)
    {
        $sucursal->delete();
        return redirect()->route('sucursales.index')->with('success', 'Sucursal eliminada.');
    }
}
