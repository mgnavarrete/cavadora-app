<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function registrar(Request $request)
    {
        // Validar datos

        $usuario = new User();
        $usuario->name = $request->signup->firstname . ' ' . $request->signup->lastname;
        //$usuario->email = $request->signup->email;
        $usuario->password = Hash::make($request->signup->password);

        $usuario->save();

        Auth::login($usuario);

        return redirect(route('index'));
    }

    public function login(Request $request)
    {
        //dd($request->input('username'), $request->input('password'));
        // Validar datos

        $credenciales = [
            'email' => $request->username,
            //'email' => $request->signin->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        } else {
            return redirect(route('inicio'))->withErrors(['error' => 'Usuario o Contraseña invalido. Por favor intenta de nuevo.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('inicio'));
    }
}
