@extends('layouts.layout')

@section('title', 'Gestión de Dosis')

@section('content')
<div class="container">
    <h1 style="color: #007bff; font-family: 'Arial', sans-serif;">Gestión de Dosis</h1>
    <!-- Botón para abrir el modal de creación -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createDosisModal">
        <i class="fas fa-plus"></i> Crear Nueva Dosis
    </button>
    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center">
            {{ $message }}
        </div>
    @endif
    <!-- Tabla de Dosis -->
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Vacuna</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosis as $dosisItem)
                <tr>
                    <td>{{ $dosisItem->nombre }}</td>
                    <td>{{ $dosisItem->vacuna->nombre }}</td>
                    <td>
                        <!-- Botón para abrir el modal de edición -->
                        <button class="btn btn-warning btn-edit" 
                                data-id="{{ $dosisItem->id }}" 
                                data-nombre="{{ $dosisItem->nombre }}" 
                                data-vacunaid="{{ $dosisItem->vacuna_id }}" 
                                data-toggle="modal" 
                                data-target="#editDosisModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- Formulario para eliminar -->
                        <form action="{{ route('dosis.destroy', $dosisItem->id) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dosis->links('pagination::bootstrap-4') }}
</div>

<!-- Modal para editar una dosis -->
<div class="modal fade" id="editDosisModal" tabindex="-1" role="dialog" aria-labelledby="editDosisModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDosisModalLabel">Editar Dosis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDosisForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-nombre">Nombre</label>
                        <input type="text" name="nombre" id="edit-nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-vacuna_id">Vacuna</label>
                        <select name="vacuna_id" id="edit-vacuna_id" class="form-control" required>
                            <option value="">Seleccione una vacuna</option>
                            @foreach ($vacunas as $vacuna)
                                <option value="{{ $vacuna->id }}">{{ $vacuna->nombre }}</option>
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

<!-- Modal para crear una nueva dosis -->
<div class="modal fade" id="createDosisModal" tabindex="-1" role="dialog" aria-labelledby="createDosisModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDosisModalLabel">Crear Nueva Dosis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('dosis.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="vacuna_id">Vacuna</label>
                        <select name="vacuna_id" id="vacuna_id" class="form-control" required>
                            <option value="">Seleccione una vacuna</option>
                            @foreach ($vacunas as $vacuna)
                                <option value="{{ $vacuna->id }}">{{ $vacuna->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Dosis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            var nombre = $(this).data('nombre');
            var vacunaId = $(this).data('vacunaid');
            
            $('#editDosisForm').attr('action', '/dosis/' + id);
            $('#edit-nombre').val(nombre);
            $('#edit-vacuna_id').val(vacunaId);
        });
    });

    function confirmDelete(event) {
        event.preventDefault();
        
        Swal.fire({
            title: '¿Estás seguro?',
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