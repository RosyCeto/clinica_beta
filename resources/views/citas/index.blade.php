@extends('layouts.layout')

@section('title', 'Lista de Citas')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary">Lista de Citas</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-right">
        <a href="{{ route('citas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Agregar Cita
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <td>{{ $cita->id }}</td>
                        <td>{{ $cita->paciente ? $cita->paciente->primer_nombre . ' ' . $cita->paciente->primer_apellido : 'No asignado' }}</td>
                        <td>{{ $cita->medico ? $cita->medico->nombre : 'No asignado' }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge {{ $cita->status === 'cancelada' ? 'bg-danger' : 'bg-success' }}">
                                {{ ucfirst($cita->status ?? 'pendiente') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('citas.cancel', $cita->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Cancelar Cita">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </form>
                            <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning btn-sm ml-2" title="Reprogramar Cita">
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $citas->links() }} <!-- Enlaces de paginación -->

</div>

<!-- Estilos adicionales -->
<style>
    .table-responsive {
        max-width: 100%;
        overflow-x: auto;
    }
    .table thead th {
        font-size: 1rem;
        text-align: center;
    }
    .badge {
        padding: 0.4em 0.75em;
        font-size: 0.85rem;
    }
    .table .btn-sm i {
        margin-right: 4px;
    }
    .text-center h1 {
        font-weight: bold;
    }
</style>
@endsection
