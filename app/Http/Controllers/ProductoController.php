<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
    }

    $datos = Producto::all();

    return view('backoffice.mantenedores.productos', [
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
            'producto_sku' => 'required|string|max:10',
            'producto_nombre' => 'required|string|max:20',
            'producto_descripcionc' => 'required|string|max:20',
            'producto_descripcionl' => 'required|string|max:50',
            'producto_precioneto' => 'required|integer',
            'producto_stockactual' => 'required|integer',
            'producto_stockminimo' => 'required|integer',
            'producto_stockbajo' => 'required|integer',
            'producto_stockalto' => 'required|integer',
        ], $this->mensajes);

try {
    //code...
    Producto::create([
        'sku' => $_request->producto_sku,
        'nombre' => $_request->producto_nombre,
        'descripcionc' => $_request->producto_descripcionc,
        'descripcionl' => $_request->producto_descripcionl,
        'precioneto' => $_request->producto_precioneto,
        'stockactual' => $_request->producto_stockactual,
        'stockminimo' => $_request->producto_stockminimo,
        'stockbajo' => $_request->producto_stockbajo,
        'stockalto' => $_request->producto_stockalto,
    ]);
    return redirect()->back()->with('success', 'Producto creado con exito.');
} catch (Exception $e) {
    return redirect()->back()->withErrors(['message' => 'Error al actualizar el producto.' . $e->getMessage()]);
}

    }

    public function enable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Producto::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = true;
            $registro->save();
            return redirect()->back()->with(['success' => 'Producto activado con exito']);
        }else{
            return redirect()->route('productos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Producto::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = false;
            $registro->save();
            return redirect()->back()->with(['success' => 'Producto desactivado con exito']);
        }else{
            return redirect()->route('productos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Producto::findOrFail($_id);
        if($registro != NULL){
            $registro->delete();
            return redirect()->back()->with(['success' => 'Producto eliminado con exito']);
        }else{
            return redirect()->route('productos.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function update(UpdateProductoRequest $request, $id)
    {
        // Ya está validado por UpdateProductoRequest

        // Verificar si hay una sesión activa
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa']);
        }

        try {
            // Encontrar el producto o lanzar una excepción 404
            $producto = Producto::findOrFail($id);

            $cambios = 0;

            // Obtener solo los campos necesarios
            $datos = $request->only([
                'producto_sku',
                'producto_nombre',
                'producto_descripcionc',
                'producto_descripcionl',
                'producto_precioneto',
                'producto_stockactual',
                'producto_stockminimo',
                'producto_stockbajo',
                'producto_stockalto',
            ]);

            // Actualizar cada campo si ha cambiado
            foreach ($datos as $campo => $valor) {
                if ($producto->$campo != $valor) {
                    $producto->$campo = $valor;
                    $cambios++;
                }
            }

            // Guardar cambios si hay alguna modificación
            if ($cambios > 0) {
                $producto->save();
                return redirect()->back()->with(['success' => 'Producto modificado con éxito']);
            } else {
                return redirect()->route('productos.index')->withErrors(['message' => 'No se realizaron cambios']);
            }

        } catch (\Exception $e) {
            // Loguear el error para depuración
            
            return redirect()->back()->withErrors(['message' => 'Error al actualizar el producto.' . $e->getMessage()]);
        }
    }
}
