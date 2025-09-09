<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRol;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contrasena' => 'required|string|min:8|confirmed', // Assuming you want a minimum of 8 characters
            'empresa' => 'required|string|max:255',
            'rol' => 'required|in:1,2'
        ]);

        //$name = ($request->filled('nombre') && $request->filled('apellidos')) ? $validatedData['nombre'] . ' ' . $validatedData['apellidos'] : null;

        $name = $validatedData['nombre'] . ' ' . $validatedData['apellidos'];

        try {
            $user = User::create([
                'name' => $name,
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['contrasena']),
                'empresa' => $validatedData['empresa'],
                'created_at' => now(),
            ]);

            try {
                $rol = UserRol::create([
                    'ur_users_id' => $user->id,
                    'ur_rol_id' => $validatedData['rol'],
                ]);

                return redirect()->route('administracion')->with('success', 'Usuario creado con exito. Se le asigna rol.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['error' => 'Usuario creado, pero hubo un error al tratar de asignarle el rol: ' . $e->getMessage()]);
            }
        } catch (\Exception $e) {
            logger()->error('User creation error: ' . $e->getMessage()); // Log the error
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el usuario. Favor intenta de nuevo.']);
        }
    }

    public function eliminarUsuario($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('administracion')->with('success', 'Usuario eliminado');
    }

    public function actualizar(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id' => 'required|exists:users,id', // Ensure the user ID exists
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id, // Allow current email
            'empresa' => 'required|string|max:255',
            'rol_edit' => 'required|int',
        ]);

        $user = User::findOrFail($request->id);

        // Actualizar
        $user->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos ?? $user->apellidos, // Update apellidos if present, otherwise keep existing
            'email' => $request->email,
            'empresa' => $request->empresa,
        ]);

        // If you're also updating roles, make sure to handle that as well
        // Assuming you have a pivot table for roles
        $user->roles()->sync($request->rol_edit); // Sync the roles if needed

        return redirect()->route('administracion')->with('success', 'Usuario actualizado correctamente');
    }
}
