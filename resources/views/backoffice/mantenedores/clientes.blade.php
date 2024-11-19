@extends('layouts.app')

@section('content')

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
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Formulario de creación de cliente -->
<form action="{{ route('clientes.create') }}" method="post">
    @csrf
    <div>
        <label for="rut">Rut:</label>
        <input id="rut" name="cliente_rut" type="text" placeholder="Rut" required>
    </div>
    <div>
        <label for="rubro">Rubro:</label>
        <input id="rubro" name="cliente_rubro" type="text" placeholder="Rubro" required>
        </div>
    <div>
        <label for="rsocial">Razon Social:</label>    
    <input id="rsocial" name="cliente_rsocial" type="text" placeholder="Razon Social" required>
    </div>
    <div>
        <label for="telefono">Telefono:</label>
    <input id="telefono" name="cliente_telefono" type="text" placeholder="Telefono" required>
    </div>
    <div>
        <label for="direccion">Direccion:</label>
    <input id="direccion" name="cliente_direccion" type="text" placeholder="Direccion" required>
    </div>
    <div>
        <label for="nombre">Nombre:</label>
    <input id="nombre" name="cliente_nombre" type="text" placeholder="Nombre" required>
    </div>
    <div>
        <label for="email">Email:</label>
    <input id="email" name="cliente_email" type="email" placeholder="Email" required>
    </div>
    <button type="submit">Crear Nuevo</button>
</form>

<hr>
@if (count($registros) == 0)
    <p>No hay datos :(</p>
@else
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Rut</th>
            <th>Rubro</th>
            <th>Razon Social</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registros as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->rut }}</td>
                <td>{{ $item->rubro }}</td>
                <td>{{ $item->rsocial }}</td>
                <td>{{ $item->telefono }}</td>
                <td>{{ $item->direccion }}</td>
                <td>{{ $item->nombre }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->activo }}</td>
                <td>
                    <!-- Activar Usuario 
                    <form action="{{ route('usuarios.enable', $item->id) }}" method="post" style="display:inline-block;">
                            @csrf
                            <button type="submit">Activar</button>
                        </form>-->

                        <!-- Desactivar Usuario 
                        <form action="{{ route('usuarios.disable', $item->id) }}" method="post" style="display:inline-block;">
                            @csrf
                            <button type="submit">Desactivar</button>
                        </form>-->

                    <button type="button" class="btn btn-primary" onclick="abrirModalEdit({{ $item->id }}, '{{ $item->rut }}', '{{ $item->rubro }}', '{{ $item->rsocial }}', '{{ $item->telefono }}', '{{ $item->direccion }}', '{{ $item->nombre }}', '{{ $item->email }}')">Editar</button>
                    <form action="{{ route('clientes.delete', $item->id)}}" method="post" style="display:inline-block;">
                        @csrf
                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

<!-- Modal para Editar Usuario -->
<div id="modalEdit" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:white; padding:20px; border:1px solid #000; z-index:1000;">
    <h2>Editar Cliente</h2>
    <form id="formEdit" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="edit_id">
        <div>
            <label for="edit_rut">Rut:</label>
            <input id="edit_rut" name="cliente_rut" type="text" required>
        </div>
        <div>
            <label for="edit_rubro">Rubro:</label>
            <input id="edit_rubro" name="cliente_rubro" type="text" required>
        </div>
        <div>
            <label for="edit_rsocial">Razon Social:</label>
            <input id="edit_rsocial" name="cliente_rsocial" type="text" required>
        </div>
        <div>
            <label for="edit_telefono">Telefono:</label>
            <input id="edit_telefono" name="cliente_telefono" type="text" required>
        </div>
        <div>
            <label for="edit_direccion">Direccion:</label>
            <input id="edit_direccion" name="cliente_direccion" type="text" required>
        </div>
        <div>
            <label for="edit_nombre">Nombre:</label>
            <input id="edit_nombre" name="cliente_nombre" type="text" required>
        </div>
        <div>
            <label for="edit_email">Email:</label>
            <input id="edit_email" name="cliente_email" type="email" required>
        </div>
        
        <button type="submit">Guardar Cambios</button>
        <button type="button" onclick="cerrarModalEdit()">Cancelar</button>
    </form>
</div>

<!-- Fondo Oscuro para el Modal -->
<div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;" onclick="cerrarModalEdit()"></div>

<script>
    function abrirModalEdit(id, rut, rubro, rsocial, telefono, direccion, nombre, email) {
        // Rellenar los campos del formulario de edición
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_rut').value = rut;
        document.getElementById('edit_rubro').value = rubro;
        document.getElementById('edit_rsocial').value = rsocial;
        document.getElementById('edit_telefono').value = telefono;
        document.getElementById('edit_direccion').value = direccion;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_email').value = email;

        // Configurar la acción del formulario
        var form = document.getElementById('formEdit');
        form.action = "{{ url('backoffice/clientes/update') }}/" + id; // Asegúrate de que la ruta sea correcta

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