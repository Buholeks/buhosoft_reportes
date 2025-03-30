<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Models\Role; // tu modelo extendido
class ControladorRol extends Controller
{
    public function index()
    {
        $empresaId = session('empresa_id');

        $roles = Role::where('id_empresa', $empresaId)->get();

        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        return view('roles.crear');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);
    
        $empresaId = session('empresa_id');
    
        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'id_empresa' => $empresaId,
        ]);
    
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }
    

    /**
     * Método para mostrar los permisos de un rol, organizados por categoría.
     */
    public function permisos($id)
    {
        $rol = Role::findOrFail($id);

        // Agrupar permisos por la segunda palabra del nombre
        $permisos = Permission::all()->groupBy(function ($permiso) {
            $partes = explode(' ', $permiso->name);
            return count($partes) > 1 ? ucfirst($partes[1]) : 'Otros'; // Usa la segunda palabra como categoría
        });

        return view('roles.permisos', compact('rol', 'permisos'));
    }

    /**
     * Método corregido para asignar permisos al rol.
     */
    public function asignarPermisos(Request $request, $id)
    {
        $rol = Role::findOrFail($id);

        // Sincronizar permisos seleccionados
        $rol->syncPermissions($request->permisos ?? []);

        return redirect()->route('roles.index')->with('success', 'Permisos asignados correctamente');
    }

    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
    }
}
