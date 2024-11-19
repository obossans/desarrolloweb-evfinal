<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function formularioLogin()
    {
        if(Auth::check()){
            return redirect()->route('backoffice.dashboard');
        }
        return view('usuario.login');
    }
    public function formularioNuevo()
    {
        if(Auth::check()){
            return redirect()->route('backoffice.dashboard');
        }
        return view('usuario.create');
    }

    public function login(Request $_request)
    {
        

        $_request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], $this->mensajes);

        $credenciales = $_request->only('email', 'password');

        if (Auth::attempt($credenciales)) {
            //verificar el usuario activo
            $user = Auth::user();
            /* if (!$user->activo){
                Auth::logout(); */
                return redirect()->route('backoffice.dashboard')/* ->withErrors(['email' => 'El usuario se encuentra desactivado.']) */;
            /* } */
            /* //Autenticacion exitosa
            $_request->session()->regenerate();
            return redirect()->route('backoffice.dashboard'); */
        }
/* 
        // echo 'siempre';
        return redirect()->back()->withErrors(['email' => 'El usuario o contrasela son incorrectos']); */

    }

    public function logout(Request $_request)
    {
        Auth::logout();
        $_request->session()->invalidate();
        $_request->session()->regenerateToken();
        return redirect()->route('usuario.login');
    }

    public function registrar(Request $_request)
    {
        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no tiene un formato valido',
            'password.required' => 'La contraseña es obligatoria',
            
        ];

        $_request->validate([
            'nombre' => 'required|string|max:50',
            'email' => 'required|email',
            'password' => 'required|string',
          
        ],  $mensajes);

        $datos = $_request->only('nombre', 'email', 'password');

        try {
            User::create([
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
                'password' => Hash::make($datos['password'])
                
            ]);
            return redirect()->route('usuario.login')->with('success', 'Usuario creado exitosamente');
        } catch (Exception $e) {
            return back()->withErrors(['message', $e->getMessage()]);
        }
    }

    public function index(){
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
    }

    $datos = User::all();

    return view('backoffice.mantenedores.usuarios', [
        'user' => $user,
        'registros' => $datos
    ]);

    }

    public function create(Request $request) {
        $user = Auth::user();
    
        // Verifica si el usuario está autenticado
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa']);
        }
    
        // Validar los datos del request
        $request->validate([
            'usuario_nombre' => 'required|string|max:50',
            'usuario_email' => 'required|string|max:50', // Eliminamos la validación de "email" para personalizar el dominio
            'usuario_password' => 'required|string|max:20'
        ], $this->mensajes);
    
        // Aseguramos que el correo termine con '@ventasfix.cl'
        $email = $request->usuario_email . '@ventasfix.cl';
    
        // Verificamos si ya existe un usuario con este correo
        if (User::where('email', $email)->exists()) {
            return redirect()->back()->withErrors(['message' => 'El correo ya está registrado.']);
        }
    
        try {
            // Crear el usuario
            User::create([
                'nombre' => $request->usuario_nombre,
                'email' => $email,
                'password' => Hash::make($request->usuario_password),
            ]);
    
            return redirect()->back()->with('success', 'Usuario creado con éxito.');
        } catch (Exception $e) {
            // Captura y maneja la excepción
            return redirect()->back()->withErrors(['message' => 'Error al crear el usuario. ' . $e->getMessage()]);
        }
    }

    public function enable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = User::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = true;
            $registro->save();
            return redirect()->back()->with(['success' => 'Usuario activado con exito']);
        }else{
            return redirect()->route('usuarios.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = User::findOrFail($_id);
        if($registro != NULL){
            $registro->activo = false;
            $registro->save();
            return redirect()->back()->with(['success' => 'Usuario desactivado con exito']);
        }else{
            return redirect()->route('usuarios.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if($user == NULL){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        $registro = User::findOrFail($_id);
        if($registro != NULL){
            $registro->delete();
            return redirect()->back()->with(['success' => 'Usuario eliminado con exito']);
        }else{
            return redirect()->route('usuarios.index')->withErrors(['message' => 'No existe registro']);
        }
    }

    public function update(Request $request, $id)
    {
        // Verificar si hay una sesión activa
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa']);
        }

        // Encontrar el usuario o lanzar una excepción 404
        $registro = User::findOrFail($id);

        // Validar los datos del request
        $request->validate([
            'usuario_nombre' => 'required|string|max:50',
            'usuario_email' => 'required|email|max:50|unique:users,email,' . $id, // Permite el email actual del usuario
            'usuario_password' => 'nullable|string|min:8|max:20' // Opcional
        ], $this->mensajes);

        $cambios = 0;

        // Actualizar nombre si ha cambiado
        if ($registro->nombre !== $request->usuario_nombre) {
            $registro->nombre = $request->usuario_nombre;
            $cambios++;
        }

        // Actualizar email si ha cambiado
        if ($registro->email !== $request->usuario_email) {
            $registro->email = $request->usuario_email;
            $cambios++;
        }

        // Actualizar password si se proporcionó
        if ($request->filled('usuario_password')) {
            $registro->password = Hash::make($request->usuario_password);
            $cambios++;
        }

        // Guardar cambios si hay alguna modificación
        if ($cambios > 0) {
            try {
                $registro->save();
                return redirect()->back()->with(['success' => 'Usuario modificado con éxito']);
            } catch (\Exception $e) {
                
                return redirect()->back()->withErrors(['message' => 'Error al actualizar el usuario.' . $e->getMessage()]);
            }
        } else {
            return redirect()->route('usuarios.index')->withErrors(['message' => 'No se realizaron cambios']);
        }
    }
}


