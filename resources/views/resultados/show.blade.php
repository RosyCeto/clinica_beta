@extends('layouts.layout')

@section('title', 'Detalles del Examen')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4" style="font-family: 'Arial', sans-serif; font-weight: bold; color: #007BFF;">Detalles del Examen</h1>
    <div class="card shadow-sm rounded" style="max-width: 500px; margin: auto; background-color: #ffffff;"> <!-- Aumento del ancho máximo -->
        <div class="card-body p-4"> <!-- Padding ajustado para un mejor equilibrio -->
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th class="text-primary">ID</th>
                        <td>{{ $examen->id }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Usuario</th>
                        <td>{{ $examen->usuario->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Paciente</th>
                        <td>{{ $examen->paciente->primer_nombre }} {{ $examen->paciente->primer_apellido }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Médico</th>
                        <td>{{ $examen->medico->nombre }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Fecha</th>
                        <td>{{ $examen->fecha }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Status</th>
                        <td>
                            @if($examen->status == 'finalizado')
                                <span class="badge bg-success">Finalizado</span>
                            @else
                                <span class="badge bg-warning">Pendiente</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-primary">Comentarios</th>
                        <td>{{ $examen->resultadoLaboratorio->comentarios ?? 'Sin comentarios' }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Fecha de Registro</th>
                        <td>{{ $examen->resultadoLaboratorio->fecha_registro ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="text-primary">Archivo</th>
                        <td>
                            @if(!empty($examen->resultadoLaboratorio->archivo))
                                <a href="{{ asset('storage/' . $examen->resultadoLaboratorio->archivo) }}" target="_blank" class="btn btn-info btn-sm">
                                    <i class="fas fa-file-download"></i>
                                </a>
                            @else
                                <span class="text-danger">No hay archivo subido.</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Espacio entre los detalles y los botones -->
            <div class="mt-4 text-center">
                <a href="{{ route('resultados.edit', $examen->id) }}" class="btn btn-warning btn-sm me-2" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('resultados.index') }}" class="btn btn-secondary btn-sm" title="Volver">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none; /* Elimina el borde de la tarjeta */
        margin-top: 20px; /* Ajusta el margen superior */
    }
    .table th {
        background-color: #e9ecef; /* Fondo gris claro para encabezados de tabla */
        color: #007BFF; /* Color azul para texto de encabezados */
        font-weight: bold; /* Aumenta el peso de la fuente para los encabezados */
    }
    .badge {
        font-size: 0.9rem; /* Tamaño de fuente más pequeño para badges */
    }
</style>
@endsection