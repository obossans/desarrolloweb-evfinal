<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
    }

    $datos = Cliente::all();

    return view('backoffice.mantenedores.clientes', [
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
            'cliente_rut' => 'required|string|max:10',
            'cliente_rubro' => 'required|string|max:20',
            'cliente_rsocial' => 'required|string|max:20',
            'cliente_telefono' => 'required|string|max:10',
            'cliente_direccion' => 'required|string|max:50',
            'cliente_nombre' => 'required|string|max:50',
            'cliente_email' => 'required|email|max:50',
        ], $this->mensajes);

try {
    //code...
    Cliente::create([
        'rut' => $_request->cliente_rut,
        'rubro' => $_request->cliente_rubro,
        'rsocial' => $_request->cliente_rsocial,
        'telefono' => $_request->cliente_telefono,
        'direccion' => $_request->cliente_direccion,
        'nombre' => $_request->cliente_nombre,
        'email' => $_request->cliente_email,
        'activo' => false,
    ]);
    return redirect()->back()->with('success', 'Cliente creado con exito.');
} catch (Exception $e) {
    //throw $th;
    return redirect()->back()->withErrors(['message' => 'Error al crear el cliente. ' . $e->getMessage()]);
}

    }

    public function enable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Cliente::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = true;
            $registro->save();
            return redirect()->back()->with(['success' => 'Cliente activado con exito']);
        }else{
            return redirect()->route('clientes.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = CLiente::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = false;
            $registro->save();
            return redirect()->back()->with(['success' => 'Cliente desactivado con exito']);
        }else{
            return redirect()->route('clientes.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = Cliente::findOrFail($_id);
        if($registro != NULL){
            $registro->delete();
            return redirect()->back()->with(['success' => 'Cliente eliminado con exito']);
        }else{
            return redirect()->route('clientes.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function update(Request $_request, $_id){
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        
        $registro = Cliente::findOrFail($_id);
                   
            $_request->validate([
            'cliente_rut' => 'required|string|max:10',
            'cliente_rubro' => 'required|string|max:20',
            'cliente_rsocial' => 'required|string|max:20',
            'cliente_telefono' => 'required|string|max:10',
            'cliente_direccion' => 'required|string|max:50',
            'cliente_nombre' => 'required|string|max:50',
            'cliente_email' => 'required|email|max:50',
            ], $this->mensajes);
            
            $cambios = 0;

            if ($registro->rut != $_request->cliente_rut){
                $registro->rut = $_request->cliente_rut;
                $cambios++;
            }
            if ($registro->rubro != $_request->cliente_rubro){
                $registro->rubro = $_request->cliente_rubro;
                $cambios++;
            }
            if ($registro->rsocial != $_request->cliente_rsocial){
                $registro->rsocial = $_request->cliente_rsocial;
                $cambios++;
            }
            if ($registro->telefono != $_request->cliente_telefono){
                $registro->telefono = $_request->cliente_telefono;
                $cambios++;
            }
            if ($registro->direccion != $_request->cliente_direccion){
                $registro->direccion = $_request->cliente_direccion;
                $cambios++;
            }
            if ($registro->nombre != $_request->cliente_nombre){
                $registro->nombre = $_request->cliente_nombre;
                $cambios++;
            }
            if ($registro->email != $_request->cliente_email){
                $registro->email = $_request->cliente_email;
                $cambios++;
            }

            if ($cambios > 0) {
                try {
                    $registro->save();
                    return redirect()->back()->with(['success' => 'Cliente modificado con éxito']);
                } catch (\Exception $e) {
                    
                    return redirect()->back()->withErrors(['message' => 'Error al actualizar el cliente.' . $e->getMessage()]);
                }
            } else {
                return redirect()->route('clientes.index')->withErrors(['message' => 'No se realizaron cambios']);
            }
        }
    }
