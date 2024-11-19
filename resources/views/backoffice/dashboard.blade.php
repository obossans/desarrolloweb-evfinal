@extends('layouts.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-4 mb-6">Dashboard</h4>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Mantenedor Clientes
                </div>
                <div class="card-body">
                    (Total: {{ $totalClientes }})
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Mantenedor Productos
                </div>
                <div class="card-body">
                    (Total: {{ $totalProductos }})
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Mantenedor Usuarios
                </div>
                <div class="card-body">
                (Total: {{ $totalUsuarios }})
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection