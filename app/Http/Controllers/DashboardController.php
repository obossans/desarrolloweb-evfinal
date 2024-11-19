<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if ($user == NULL) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa']);
        }
        // Obtener el conteo total de registros en cada mantenedor
        $totalProyectos = Proyecto::count();
        $totalClientes = Cliente::count();
        $totalProductos = Producto::count();
        $totalUsuarios = User::count();

        // Pasar estos datos a la vista
        return view('backoffice.dashboard', [
            'totalProyectos' => $totalProyectos,
            'totalClientes' => $totalClientes,
            'totalProductos' => $totalProductos,
            'totalUsuarios' => $totalUsuarios,
        ]);
    }
}