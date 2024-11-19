<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
    }

    $datos = Proyecto::all();

    return view('backoffice.mantenedores.proyectos', [
        'user' => $user,
        'registros' => $datos
    ]);

    }

    public function create(Request $_request) {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $_request->validate([
            'proyecto_nombre' => 'required|string|max:255',
            'proyecto_descripcion' => 'required|string|max:1000',
        ], $this->mensajes);

try {
    //code...
    Proyecto::create([
        'nombre' => $_request->proyecto_nombre,
        'descripcion' => $_request->proyecto_descripcion,
        'activo' => false,
    ]);
    return redirect()->back()->with('success', 'Proyecto creado con exito.');
} catch (Exception $e) {
    //throw $th;
}

    }

    public function enable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Proyecto::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = true;
            $registro->save();
            return redirect()->back()->with(['success' => 'Proyecto activado con exito']);
        }else{
            return redirect()->route('proyectos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Proyecto::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = false;
            $registro->save();
            return redirect()->back()->with(['success' => 'Proyecto desactivado con exito']);
        }else{
            return redirect()->route('proyectos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Proyecto::findOrFail($_id);
        if($registro != NULL){
            $registro->delete();
            return redirect()->back()->with(['success' => 'Proyecto eliminado con exito']);
        }else{
            return redirect()->route('proyectos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function update(Request $request, $id)
    {
        // Verificar si hay una sesión activa
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa']);
        }

        try {
            // Encontrar el proyecto o lanzar una excepción 404
            $proyecto = Proyecto::findOrFail($id);

            // Validar los datos del request
            $request->validate([
                'proyecto_nombre' => 'required|string|max:255',
                'proyecto_descripcion' => 'required|string|max:1000',
            ], $this->mensajes);

            $cambios = 0;

            // Obtener solo los campos necesarios
            $datos = $request->only('proyecto_nombre', 'proyecto_descripcion');

            // Actualizar nombre si ha cambiado
            if ($proyecto->nombre !== $datos['proyecto_nombre']) {
                $proyecto->nombre = $datos['proyecto_nombre'];
                $cambios++;
            }

            // Actualizar descripción si ha cambiado
            if ($proyecto->descripcion !== $datos['proyecto_descripcion']) {
                $proyecto->descripcion = $datos['proyecto_descripcion'];
                $cambios++;
            }

            // Guardar cambios si hay alguna modificación
            if ($cambios > 0) {
                $proyecto->save();
                return redirect()->back()->with(['success' => 'Proyecto modificado con éxito']);
            } else {
                return redirect()->route('proyectos.index')->withErrors(['message' => 'No se realizaron cambios']);
            }

        } catch (\Exception $e) {
            // Loguear el error para depuración

            return redirect()->back()->withErrors(['message' => 'Error al actualizar el proyecto.' . $e->getMessage()]);
        }
    }

}
