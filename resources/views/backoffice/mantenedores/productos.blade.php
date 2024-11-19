@extends('layouts.app')

@section('content')

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
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para Crear Nuevo Producto -->
    <form action="{{ route('productos.create') }}" method="post">
        @csrf
        <div>
            <label for="sku">SKU:</label>
            <input id="sku" name="producto_sku" type="text" placeholder="SKU" required>
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input id="nombre" name="producto_nombre" type="text" placeholder="Nombre" required>
        </div>
        <div>
            <label for="descripcionc">Descripción Corta:</label>
            <input id="descripcionc" name="producto_descripcionc" type="text" placeholder="Descripción Corta" required>
        </div>
        <div>
            <label for="descripcionl">Descripción Larga:</label>
            <input id="descripcionl" name="producto_descripcionl" type="text" placeholder="Descripción Larga" required>
        </div>
        <div>
            <label for="precioneto">Precio Neto:</label>
            <input id="precioneto" name="producto_precioneto" type="number" step="0.01" placeholder="Precio Neto" required>
        </div>
        <div>
            <label for="stockactual">Stock Actual:</label>
            <input id="stockactual" name="producto_stockactual" type="number" placeholder="Stock Actual" required>
        </div>
        <div>
            <label for="stockminimo">Stock Mínimo:</label>
            <input id="stockminimo" name="producto_stockminimo" type="number" placeholder="Stock Mínimo" required>
        </div>
        <div>
            <label for="stockbajo">Stock Bajo:</label>
            <input id="stockbajo" name="producto_stockbajo" type="number" placeholder="Stock Bajo" required>
        </div>
        <div>
            <label for="stockalto">Stock Alto:</label>
            <input id="stockalto" name="producto_stockalto" type="number" placeholder="Stock Alto" required>
        </div>
        <button type="submit">Crear Nuevo</button>
    </form>
    <hr>

    <!-- Tabla de Productos -->
    @if (count($registros) == 0)
        <p>No hay datos :(</p>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Nombre</th>
                    <th>Descripción Corta</th>
                    <th>Descripción Larga</th>
                    <th>Precio Neto</th>
                    <th>Stock Actual</th>
                    <th>Stock Mínimo</th>
                    <th>Stock Bajo</th>
                    <th>Stock Alto</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->sku }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->descripcionc }}</td>
                        <td>{{ $item->descripcionl }}</td>
                        <td>{{ $item->precioneto }}</td>
                        <td>{{ $item->stockactual }}</td>
                        <td>{{ $item->stockminimo }}</td>
                        <td>{{ $item->stockbajo }}</td>
                        <td>{{ $item->stockalto }}</td>
                        <td>{{ $item->activo }}</td>
                        <td>
                            <!-- Activar Producto 
                            <form action="{{ route('productos.enable', $item->id) }}" method="post" style="display:inline-block;">
                                @csrf
                                <button type="submit">Activar</button>
                            </form>-->

                            <!-- Desactivar Producto 
                            <form action="{{ route('productos.disable', $item->id) }}" method="post" style="display:inline-block;">
                                @csrf
                                <button type="submit">Desactivar</button>
                            </form>-->

                            <!-- Editar Producto -->
                            <button type="button" class="btn btn-primary" onclick="abrirModalEdit({{ $item->id }}, '{{ $item->sku }}', '{{ $item->nombre }}', '{{ $item->descripcionc }}', '{{ $item->descripcionl }}', '{{ $item->precioneto }}', '{{ $item->stockactual }}', '{{ $item->stockminimo }}', '{{ $item->stockbajo }}', '{{ $item->stockalto }}')">Editar</button>

                            <!-- Eliminar Producto -->
                            <form action="{{ route('productos.delete', $item->id) }}" method="post" style="display:inline-block;">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal para Editar Producto -->
    <div id="modalEdit" style="display:none; position:fixed; top:10%; left:50%; transform:translateX(-50%); background:white; padding:20px; border:1px solid #000; z-index:1000;">
        <h2>Editar Producto</h2>
        <form id="formEdit" method="post">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_sku">SKU:</label>
                <input id="edit_sku" name="producto_sku" type="text" placeholder="SKU" required>
            </div>
            <div>
                <label for="edit_nombre">Nombre:</label>
                <input id="edit_nombre" name="producto_nombre" type="text" placeholder="Nombre" required>
            </div>
            <div>
                <label for="edit_descripcionc">Descripción Corta:</label>
                <input id="edit_descripcionc" name="producto_descripcionc" type="text" placeholder="Descripción Corta" required>
            </div>
            <div>
                <label for="edit_descripcionl">Descripción Larga:</label>
                <input id="edit_descripcionl" name="producto_descripcionl" type="text" placeholder="Descripción Larga" required>
            </div>
            <div>
                <label for="edit_precioneto">Precio Neto:</label>
                <input id="edit_precioneto" name="producto_precioneto" type="number" step="0.01" placeholder="Precio Neto" required>
            </div>
            <div>
                <label for="edit_stockactual">Stock Actual:</label>
                <input id="edit_stockactual" name="producto_stockactual" type="number" placeholder="Stock Actual" required>
            </div>
            <div>
                <label for="edit_stockminimo">Stock Mínimo:</label>
                <input id="edit_stockminimo" name="producto_stockminimo" type="number" placeholder="Stock Mínimo" required>
            </div>
            <div>
                <label for="edit_stockbajo">Stock Bajo:</label>
                <input id="edit_stockbajo" name="producto_stockbajo" type="number" placeholder="Stock Bajo" required>
            </div>
            <div>
                <label for="edit_stockalto">Stock Alto:</label>
                <input id="edit_stockalto" name="producto_stockalto" type="number" placeholder="Stock Alto" required>
            </div>
            <button type="submit">Guardar Cambios</button>
            <button type="button" onclick="cerrarModalEdit()">Cancelar</button>
        </form>
    </div>

    <!-- Fondo Oscuro para el Modal -->
    <div id="overlay" onclick="cerrarModalEdit()"></div>

    <script>
        function abrirModalEdit(id, sku, nombre, descripcionc, descripcionl, precioneto, stockactual, stockminimo, stockbajo, stockalto) {
            // Rellenar los campos del formulario de edición
            document.getElementById('edit_sku').value = sku;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_descripcionc').value = descripcionc;
            document.getElementById('edit_descripcionl').value = descripcionl;
            document.getElementById('edit_precioneto').value = precioneto;
            document.getElementById('edit_stockactual').value = stockactual;
            document.getElementById('edit_stockminimo').value = stockminimo;
            document.getElementById('edit_stockbajo').value = stockbajo;
            document.getElementById('edit_stockalto').value = stockalto;

            // Configurar la acción del formulario
            var form = document.getElementById('formEdit');
            form.action = "{{ url('backoffice/productos/update') }}/" + id ; // Asegúrate de que la ruta sea correcta

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