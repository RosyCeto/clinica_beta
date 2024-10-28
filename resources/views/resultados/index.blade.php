@extends('layouts.layout')

@section('title', 'Lista de Exámenes Realizados')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: #007BFF;">Lista de Exámenes/Resultados</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario de Búsqueda -->
    <form action="{{ route('resultados.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por ID, Usuario, Paciente, Médico o Fecha" value="{{ request()->input('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </div>
        </div>
    </form>

    <div class="mb-3 text-right">
        <a href="{{ route('realizar_examenes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($realizarExamenes as $examen)
                <tr>
                    <td>{{ $examen->id }}</td>
                    <td>{{ $examen->usuario->name }}</td>
                    <td>{{ $examen->paciente->primer_nombre }} {{ $examen->paciente->primer_apellido }}</td>
                    <td>{{ $examen->medico->nombre }}</td>
                    <td>{{ $examen->fecha }}</td>
                    <td>
                        @if($examen->status == 'finalizado')
                            <span class="badge badge-success">Finalizado</span>
                        @else
                            <span class="badge badge-warning">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('resultados.show', $examen->id) }}" class="btn btn-info btn-sm" title="Ver Detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($examen->status == 'pendiente')
                            <a href="{{ route('resultados.create', $examen->id) }}" class="btn btn-success btn-sm" title="Subir Resultados">
                                <i class="fas fa-upload"></i>
                            </a>
                        @endif
                        <a href="{{ route('resultados.edit', $examen->id) }}" class="btn btn-warning btn-sm" title="Editar Examen">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay exámenes registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $realizarExamenes->links() }}
    </div>

</div>

<style>
    .table th {
        background-color: #343a40; /* Cambiar color de encabezado a un gris oscuro */
        color: #ffffff; /* Cambiar color de texto a blanco */
    }
    .badge {
        font-size: 0.9rem; /* Tamaño de fuente más pequeño para badges */
    }
    .alert {
        margin-top: 20px; /* Espaciado entre alertas y contenido */
    }
</style>
@endsection