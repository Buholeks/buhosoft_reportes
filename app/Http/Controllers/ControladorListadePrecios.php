<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListadePrecios;
use App\Models\Tipoproducto;
use App\Models\Metodopago;

class ControladorListadePrecios extends Controller
{
    public function index(Request $request)
    {
        $tiposEquipos = TipoProducto::all();
        $tiposVentas = MetodoPago::all();
        $empresaId = session('empresa_id');
    
        // Solo traemos lo que pertenece a la empresa actual
        $listadeprecios = ListadePrecios::where('id_empresa', $empresaId)
        ->orderBy('id', 'desc')
        ->get();
        return view('listadeprecios.index', compact('listadeprecios', 'tiposEquipos', 'tiposVentas'));
    }
    

    public function edit($id)
    {
        $precio = Listadeprecios::findOrFail($id);

        return response()->json([
            'id' => $precio->id,
            'descripcion' => $precio->descripcion,
            'precio' => $precio->precio,
            'precio_promocion' => $precio->precio_promocion,
            'tipoe' => $precio->tipoe,
            'tipove' => $precio->tipove,
        ]);
    }
    
    public function create()
    {
        $registro = new Listadeprecios(); // objeto vacío
        $modo = 'Crear';
        $tiposEquipos = TipoProducto::all();
        $tiposVentas = MetodoPago::all();

        return view('listadeprecios.create', compact('registro', 'modo', 'tiposEquipos', 'tiposVentas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:45',
            'tipoe' => 'required|string|max:45',
            'tipove' => 'required|string|max:45',
            'precio' => 'required|numeric|min:0',
            'precio_promocion' => 'nullable|numeric|min:0',
        ]);
    
        $empresaId = session('empresa_id');
    
        // Usamos fill() para mantener seguridad con fillable
        $registro = new Listadeprecios();
        $registro->fill($request->all());
        $registro->id_empresa = $empresaId;
        $registro->save();
    
        return redirect()->route('listadeprecios.index')->with('success', 'Precio registrado correctamente.');
    }
    

    public function update(Request $request, Listadeprecios $listadeprecio)
    {
        $request->validate([
            'descripcion' => 'required|string|max:45',
            'tipoe' => 'nullable|exists:tabla_tipoproducto,id',
            'tipove' => 'nullable|exists:tabla_metodopagos,id',
            'precio_promocion' => 'nullable|numeric|min:0',
        ]);

        // Si el nuevo precio_promocion es diferente del actual
        if ($request->filled('precio_promocion') && $request->precio_promocion != $listadeprecio->precio_promocion) {
            // Mover el valor actual de 'precio_promocion' a 'precio'
            $listadeprecio->precio = $listadeprecio->precio_promocion;

            // Guardar el nuevo valor en 'precio_promocion'
            $listadeprecio->precio_promocion = $request->precio_promocion;
        }

        // Actualizar el resto de los campos
        $listadeprecio->descripcion = $request->descripcion;
        $listadeprecio->tipoe = $request->tipoe;
        $listadeprecio->tipove = $request->tipove;
        $listadeprecio->precio_promocion = $request->precio_promocion;

        $listadeprecio->save();

        return redirect()->route('listadeprecios.index')->with('success', 'Precio actualizado correctamente.');
    }

    public function destroy(Listadeprecios $listadeprecio)
    {
        $listadeprecio->delete();
        return redirect()->route('listadeprecios.index')->with('success', 'Precio eliminado correctamente.');
    }
}
