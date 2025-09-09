<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Carbon\Carbon;

class AdministracionController extends Controller
{
    public function index()
    {
        $usuarios = User::with('roles')->get();
        $roles = Rol::with('permisos')->get();
        $permisos = Permiso::get();
        
        return view('pages.administracion', compact('usuarios', 'roles', 'permisos'));
    }

    public function crearPermiso(Request $request)
    {
        $validatedData = $request->validate([
            'prm_nombre' => 'required|string|max:255',
            'prm_desc' => 'required|string|max:255',
        ]);

        try {
            $permiso = Permiso::create([
                'prm_nombre' => $validatedData['prm_nombre'],
                'prm_desc' => $validatedData['prm_desc'],
            ]);

            return redirect()->route('administracion')->with('success', 'Permiso creado con exito.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear permiso: ' . $e->getMessage()]);
        }
    }

    public function crearRol(Request $request)
    {

        dump($request);
        return;

        $validatedData = $request->validate([
            'rol_nombre' => 'required|string|max:255',
            'rol_desc' => 'required|string|max:255',
            'rol_prm' => 'nullable', 
        ]);

        try {
            $rol = Rol::create([
                'rol_nombre' => $validatedData['rol_nombre'],
                'rol_desc' => $validatedData['rol_desc'],
            ]);

            if (isset($validatedData['rol_prm'])) {

                foreach ($validatedData['rol_prm'] as $permiso_id) {
                    RolPermiso::create([
                        'rp_rol_id' => $rol->rol_id,
                        'rp_prm_id' => $permiso_id,
                    ]);
                }
            }

            return redirect()->route('administracion')->with('success', 'Permiso creado con exito.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear permiso: ' . $e->getMessage()]);
        }
    }

    public function editarRol(Request $request)
    {

        $validatedData = $request->validate([
            'rol_id' => 'required|int',
            'rol_nombre_edit' => 'required|string|max:255',
            'rol_desc_edit' => 'required|string|max:255',
            'rol_prm_edit' => 'nullable', 
        ]);

        try {

            $rol = Rol::findOrFail($validatedData['rol_id']);

            $rol->update([
                'rol_nombre' => $validatedData['rol_nombre_edit'],
                'rol_desc' => $validatedData['rol_desc_edit'],
            ]);

            if (isset($validatedData['rol_prm_edit'])) {

                RolPermiso::where('rp_rol_id', $rol->id)->delete();

                foreach ($validatedData['rol_prm_edit'] as $permiso_id) {
                    RolPermiso::create([
                        'rp_rol_id' => $rol->rol_id,
                        'rp_prm_id' => $permiso_id,
                    ]);
                }
            }
            

            return redirect()->route('administracion')->with('success', 'Rol editado.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al editar rol: ' . $e->getMessage()]);
        }
    }

}