@extends('layouts.layout')

@section('title', 'Vacunas')

@section('content')
<div class="container">
    <h1 class="text-left" style="color: #007bff; font-family: Arial, sans-serif;">Vacunas</h1>
    <div class="text-right mb-3">
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#createVacunaModal">
            <i class="fas fa-plus"></i> Agregar Vacuna
        </a>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vacunas as $vacuna)
                <tr>
                    <td>{{ $vacuna->nombre }}</td>
                    <td>
                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#editVacunaModal{{ $vacuna->id }}" onclick="editVacuna('{{ $vacuna->id }}', '{{ $vacuna->nombre }}')">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('vacunas.destroy', $vacuna) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>

                <!-- Modal para editar una vacuna -->
                <div class="modal fade" id="editVacunaModal{{ $vacuna->id }}" tabindex="-1" role="dialog" aria-labelledby="editVacunaLabel{{ $vacuna->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editVacunaLabel{{ $vacuna->id }}">Editar Vacuna</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario de edición de Vacuna -->
                                <form action="{{ route('vacunas.update', $vacuna) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nombre">Nombre de la Vacuna</label>
                                        <input type="text" class="form-control" id="edit-nombre-{{ $vacuna->id }}" name="nombre" value="{{ $vacuna->nombre }}" required>
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
    {{ $vacunas->links('pagination::bootstrap-4') }} <!-- Paginación -->
</div>

<!-- Modal para crear una nueva vacuna -->
<div class="modal fade" id="createVacunaModal" tabindex="-1" role="dialog" aria-labelledby="createVacunaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createVacunaLabel">Agregar Nueva Vacuna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de creación de Vacuna -->
                <form action="{{ route('vacunas.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre de la Vacuna</label>
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
    function editVacuna(id, nombre) {
        document.getElementById('edit-nombre-' + id).value = nombre;
    }

    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Está seguro que quiere eliminar esta vacuna?',
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