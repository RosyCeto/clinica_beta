@extends('layouts.layout')

@section('title', 'Gestión de Exámenes')

@section('content')
<style>
    .container {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
        font-family: 'Verdana', sans-serif;
        font-size: 1rem;
    }

    .table th {
        background-color: #343a40;
        color: white;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-footer .btn {
        border-radius: 5px;
    }
</style>

<div class="container mt-4">
    <h1 class="text-primary font-weight-bold" style="font-family: 'Arial', sans-serif;">Gestión de Exámenes</h1>
    <!-- Botón para abrir el modal de creación -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createExamenModal">
        <i class="fas fa-plus"></i> Crear Nuevo Examen
    </button>
    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center">
            {{ $message }}
        </div>
    @endif
    <!-- Tabla de Exámenes -->
    <table class="table table-striped table-bordered shadow-sm">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Tipo de Análisis</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($examenes as $examen)
                <tr>
                    <td>{{ $examen->nombre }}</td>
                    <td>{{ $examen->tipoAnalisis->nombre }}</td>
                    <td>
                        <!-- Botón para abrir el modal de edición, precargando los datos -->
                        <button class="btn btn-warning btn-edit" data-id="{{ $examen->id }}" data-nombre="{{ $examen->nombre }}" data-tipoanalisisid="{{ $examen->tipo_analisis_id }}" data-toggle="modal" data-target="#editExamenModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- Formulario para eliminar -->
                        <form action="{{ route('examenes.destroy', $examen->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- Modal para editar un examen -->
                <div class="modal fade" id="editExamenModal{{ $examen->id }}" tabindex="-1" role="dialog" aria-labelledby="editExamenModalLabel{{ $examen->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editExamenModalLabel{{ $examen->id }}">Editar Examen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editExamenForm{{ $examen->id }}" action="{{ route('examenes.update', $examen->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="edit-nombre-{{ $examen->id }}">Nombre</label>
                                        <input type="text" name="nombre" id="edit-nombre-{{ $examen->id }}" class="form-control" value="{{ $examen->nombre }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-tipo_analisis_id-{{ $examen->id }}">Tipo de Análisis</label>
                                        <select name="tipo_analisis_id" id="edit-tipo_analisis_id-{{ $examen->id }}" class="form-control" required>
                                            <option value="">Seleccione un tipo de análisis</option>
                                            @foreach ($tiposAnalisis as $tipo)
                                                <option value="{{ $tipo->id }}" {{ $tipo->id == $examen->tipo_analisis_id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    {{ $examenes->links('pagination::bootstrap-4') }}
</div>

<!-- Modal para crear un nuevo examen -->
<div class="modal fade" id="createExamenModal" tabindex="-1" role="dialog" aria-labelledby="createExamenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="createExamenModalLabel">Crear Nuevo Examen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('examenes.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_analisis_id">Tipo de Análisis</label>
                        <select name="tipo_analisis_id" id="tipo_analisis_id" class="form-control" required>
                            <option value="">Seleccione un tipo de análisis</option>
                            @foreach ($tiposAnalisis as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   
    $(document).ready(function() {
        $(document).on('click', '.btn-edit', function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var tipo_analisis_id = $(this).data('tipoanalisisid');

            $('#edit-nombre-' + id).val(nombre);
            $('#edit-tipo_analisis_id-' + id).val(tipo_analisis_id);

            $('#editExamenForm' + id).attr('action', '/examenes/' + id);
            $('#editExamenModal' + id).modal('show');
        });
    });


    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro de que deseas eliminar este examen?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); 
            }
        });
    }
</script>
@endsection