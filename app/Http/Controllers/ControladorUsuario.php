<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ControladorUsuario extends Controller
{
    public function index()
    {
        $empresaId = session('empresa_id');

        if (!$empresaId) {
            return redirect()->back()->with('error', 'No hay una empresa activa en la sesión.');
        }

        $usuarios = User::where('id_empresa', $empresaId)->get();

        return view('usuarios.index', compact('usuarios'));
    }


    public function create()
    {
        return view('usuarios.crear');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $empresaId = session('empresa_id');

        if (!$empresaId) {
            return redirect()->back()->with('error', 'No se encontró una empresa activa en la sesión.');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_empresa' => $empresaId,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }


    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    public function roles($id)
    {
        $usuario = User::findOrFail($id);
        $empresaId = session('empresa_id');

        if (!$empresaId) {
            return redirect()->back()->with('error', 'No hay empresa activa en la sesión.');
        }

        $roles = Role::where('id_empresa', $empresaId)->get();

        return view('usuarios.roles', compact('usuario', 'roles'));
    }


    public function asignarRoles(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncRoles($request->roles);
        return redirect()->route('usuarios.index')->with('success', 'Roles asignados correctamente');
    }


    public function permisos($id)
    {
        $usuario = User::findOrFail($id);

        // Agrupar permisos por la segunda palabra del nombre (usuarios, roles, permisos, etc.)
        $permisos = Permission::all()->groupBy(function ($permiso) {
            $partes = explode(' ', $permiso->name);
            return count($partes) > 1 ? ucfirst($partes[1]) : 'Otros'; // Toma la segunda palabra
        });

        return view('usuarios.permisos', compact('usuario', 'permisos'));
    }


    public function asignarPermisos(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->syncPermissions($request->permisos);
        return redirect()->route('usuarios.index')->with('success', 'Permisos asignados correctamente');
    }
}
