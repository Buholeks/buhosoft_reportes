<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegistroControlador extends Controller
{
    public function showRegistrationForm()
    {
        return view('autenticacion.registro');
    }

    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();
    
            $this->create($request->all());
    
            return redirect()->route('login')->with('success', 'Usuario registrado correctamente.');

        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al registrar el usuario.');
        }
    }
    

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        Log::info('Creating user with data:', $data);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
