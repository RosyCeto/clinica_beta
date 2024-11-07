@extends('layouts.layout')

@section('title', 'Tipos de Análisis')

@section('content')
<div class="container mt-5">
    <h1 class="text-left" style="color: #007bff; font-family: 'Poppins', sans-serif; font-weight: 600;">Tipos de Análisis</h1>
    <div class="text-right mb-3">
        <a href="#" class="btn btn-success shadow" data-toggle="modal" data-target="#createTipoAnalisisModal">
            <i class="fas fa-plus"></i> Crear Nuevo Tipo de Análisis
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center shadow">{{ $message }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tiposAnalisis as $tipo)
                    <tr>
                        <td>{{ $tipo->nombre }}</td>
                        <td>
                            <a href="#" class="btn btn-warning shadow" data-toggle="modal" data-target="#editTipoAnalisisModal{{ $tipo->id }}" onclick="editTipoAnalisis('{{ $tipo->id }}', '{{ $tipo->nombre }}')">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('tipos-analisis.destroy', $tipo->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger shadow">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <!-- Modal para editar un tipo de análisis -->
                    <div class="modal fade" id="editTipoAnalisisModal{{ $tipo->id }}" tabindex="-1" role="dialog" aria-labelledby="editTipoAnalisisLabel{{ $tipo->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editTipoAnalisisLabel{{ $tipo->id }}">Editar Tipo de Análisis</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición de Tipo de Análisis -->
                                    <form action="{{ route('tipos-analisis.update', $tipo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="nombre">Nombre del Tipo de Análisis</label>
                                            <input type="text" class="form-control" id="edit-nombre-{{ $tipo->id }}" name="nombre" value="{{ $tipo->nombre }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $tiposAnalisis->links('pagination::bootstrap-4') }}
</div>

<!-- Modal para crear un nuevo tipo de análisis -->
<div class="modal fade" id="createTipoAnalisisModal" tabindex="-1" role="dialog" aria-labelledby="createTipoAnalisisLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTipoAnalisisLabel">Crear Nuevo Tipo de Análisis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de creación de Tipo de Análisis -->
                <form action="{{ route('tipos-analisis.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre del Tipo de Análisis</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editTipoAnalisis(id, nombre) {
        document.getElementById('edit-nombre-' + id).value = nombre;
    }

    // Confirmación de eliminación con SweetAlert
    function confirmDelete(event) {
        event.preventDefault(); 
        Swal.fire({
            title: '¿Está seguro que quiere eliminar este tipo de análisis?',
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

<style>
    
    .table {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .table th, .table td {
        vertical-align: middle;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
    }
    
    .modal-content {
        border-radius: 0.5rem;
    }

    .shadow {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
    }

    h1 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }

    .alert {
        border-radius: 0.5rem;
    }
</style>
@endsection