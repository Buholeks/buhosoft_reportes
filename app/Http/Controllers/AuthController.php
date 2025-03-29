<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Guardar en sesión el id del usuario y la empresa
            session([
                'user_id'    => $user->id,
                'empresa_id' => $user->id_empresa,
            ]);
            // Cargar las sucursales de la empresa
            $sucursales = Sucursal::where('id_empresa', $user->id_empresa)->get();
            session(['sucursales' => $sucursales]);

            // Redirigir a la vista de selección de sucursal
            // Asegúrate de tener definida esta ruta (por ejemplo, 'sucursal.selection')
            return redirect()->route('vista_sucursal')
                ->with('success', 'Inicio de sesión exitoso');
        }

        return redirect()->route('login')->withErrors([
            'email' => 'Error de Usuario o Contraseña, Intente de Nuevo.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); // Invalida la sesión actual
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect('/login'); // Redirigir a la página de inicio de sesión
    }
}
