<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" class="style">
    <script type="text/javascript" src="{{ asset('js/script.js') }}" ></script>
    <title>Dashboard del backoffice</title>
</head>
<body>
<h1>Dashboard</h1>
<p>Ir al mantenedor de proyectos:</p>
<ul>
    <li><a href="{{ route('clientes.index') }}">Clientes</a> (Total: {{ $totalClientes }})</li>
    <li><a href="{{ route('productos.index') }}">Productos</a> (Total: {{ $totalProductos }})</li>
    <li><a href="{{ route('usuarios.index') }}">Usuarios</a> (Total: {{ $totalUsuarios }})</li>
</ul>
</body>
</html>