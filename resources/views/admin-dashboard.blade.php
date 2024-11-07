@extends('layouts.layout')

@section('title', 'Dashboard del Administrador')

@section('header', 'Bienvenido, Administrador')

@section('content')
    <p>Aquí puedes gestionar usuarios, permisos, y otros datos del sistema.</p>

    <!-- Tarjeta de Nuevos Usuarios -->
    <div class="card">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <img src="{{ asset('plantilla/dist/img/usuarios.jpg') }}" alt="Icono de nuevos usuarios" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
            </div>
            <div>
                <h5 class="card-title">{{ $nuevosUsuarios }} Nuevos Usuarios</h5>
                <p class="card-text">Usuarios registrados en el último mes.</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Ver Usuarios</a>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Reportes -->
    <div class="card mt-3">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <img src="{{ asset('plantilla/dist/img/reporte.jpg') }}" alt="Icono de Reportes" class="img-fluid" style="width: 80px; height: 80px; border-radius: 50%;">
            </div>
            <div>
                <h5 class="card-title">Reportes</h5>
                <p class="card-text">Generar reportes de pacientes, historiales clínicos y farmacia.</p>
                <a href="{{ route('reportes.index') }}" class="btn btn-primary">Ver Reportes</a>
                
            </div>
        </div>
    </div>
@endsection