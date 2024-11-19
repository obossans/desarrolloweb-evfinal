@extends('layouts.app')

@section('content')

<h1>Mantenedor de Proyectos</h1>
<hr>

<!-- Mostrar Errores -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <hr>
@endif

<!-- Mostrar Mensajes de Éxito -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Formulario para Crear Nuevo Proyecto -->
<h2>Crear Nuevo Proyecto</h2>
<form action="{{ route('proyectos.create') }}" method="post">
    @csrf
    <div>
        <label for="nombre">Nombre:</label>
        <input id="nombre" name="proyecto_nombre" type="text" placeholder="Nombre" required>
    </div>
    <div>
        <label for="descripcion">Descripción:</label>
        <input id="descripcion" name="proyecto_descripcion" type="text" placeholder="Descripción" required>
    </div>
    <button type="submit">Crear Nuevo</button>
</form>
<hr>

<!-- Tabla de Proyectos -->
@if (count($registros) == 0)
    <p>No hay datos :(</p>
@else
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <!-- Activar Proyecto 
                        <form action="{{ route('proyectos.enable', $item->id) }}" method="post" style="display:inline-block;">
                            @csrf
                            <button type="submit">Activar</button>
                        </form>-->

                        <!-- Desactivar Proyecto 
                        <form action="{{ route('proyectos.disable', $item->id) }}" method="post" style="display:inline-block;">
                            @csrf
                            <button type="submit">Desactivar</button>
                        </form>-->

                        <!-- Editar Proyecto -->
                        <button type="button" onclick="abrirModalEdit({{ $item->id }}, '{{ addslashes($item->nombre) }}', '{{ addslashes($item->descripcion) }}')">Editar</button>

                        <!-- Eliminar Proyecto -->
                        <form action="{{ route('proyectos.delete', $item->id) }}" method="post" style="display:inline-block;">
                            @csrf
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este proyecto?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<!-- Modal para Editar Proyecto -->
<div id="modalEdit" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:white; padding:20px; border:1px solid #000; z-index:1000;">
    <h2>Editar Proyecto</h2>
    <form id="formEdit" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="edit_id">
        <div>
            <label for="edit_nombre">Nombre:</label>
            <input id="edit_nombre" name="proyecto_nombre" type="text" required>
        </div>
        <div>
            <label for="edit_descripcion">Descripción:</label>
            <input id="edit_descripcion" name="proyecto_descripcion" type="text" required>
        </div>
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="cerrarModalEdit()">Cancelar</button>
    </form>
</div>

<!-- Fondo Oscuro para el Modal -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;" onclick="cerrarModalEdit()"></div>

<script>
    function abrirModalEdit(id, nombre, descripcion) {
        // Rellenar los campos del formulario de edición
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_descripcion').value = descripcion;

        // Configurar la acción del formulario
        var form = document.getElementById('formEdit');
        form.action = "{{ url('backoffice/proyectos/update') }}/" + id ; // Asegúrate de que la ruta sea correcta

        // Mostrar el modal y el overlay
        document.getElementById('modalEdit').style.display = 'block';
        document.getElementById('overlay').style.display = 'block';
    }

    function cerrarModalEdit() {
        // Ocultar el modal y el overlay
        document.getElementById('modalEdit').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    }
</script>
@endsection