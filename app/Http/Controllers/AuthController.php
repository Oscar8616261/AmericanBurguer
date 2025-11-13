<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'ci' => 'required'
        ]);

        // Intentamos autenticar como Cliente
        $cliente = ClienteModel::where('email', $request->email)
                              ->where('ci', $request->ci)
                              ->first();

        // Intentamos autenticar como Usuario
        $usuario = UsuarioModel::where('email', $request->email)
                              ->where('ci', $request->ci)
                              ->first();

        if ($cliente) {
            Auth::guard('clientes')->login($cliente);
            return redirect()->route('home')->with('success', 'Bienvenido Cliente');
        } elseif ($usuario) {
            Auth::guard('web')->login($usuario);
            return redirect()->route('home')->with('success', 'Bienvenido Usuario');
        } else {
            return back()->withErrors(['error' => 'Credenciales incorrectas']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Sesión cerrada');
    }
}