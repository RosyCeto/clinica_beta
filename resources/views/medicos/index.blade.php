@extends('layouts.layout')

@section('title', 'Lista de Médicos')

@section('content')
<div class="container">
    <h1>Lista de Médicos</h1>

    <!-- Mensajes de éxito o error -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Buscador -->
    <form method="GET" action="{{ route('medicos.index') }}" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-sm-2" placeholder="Buscar por nombre o CUI" value="{{ request()->query('search') }}">
        <button type="submit" class="btn btn-outline-success"><i class="fas fa-search"></i></button>
    </form>

    <!-- Botón para Agregar Médico -->
    <button type="button" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#createMedicoModal">
        <i class="fas fa-plus"></i> Agregar Médico
    </button>

    <!-- Modal para Crear Médico -->
    <div class="modal fade" id="createMedicoModal" tabindex="-1" role="dialog" aria-labelledby="createMedicoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMedicoModalLabel">Agregar Médico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('medicos.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cui">CUI</label>
                            <input type="text" name="cui" class="form-control" maxlength="13">
                        </div>
                        <div class="form-group">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" name="especialidad" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" maxlength="8" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Médicos -->
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>CUI</th>
                <th>Especialidad</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medicos as $medico)
                <tr>
                    <td>{{ $medico->nombre }}</td>
                    <td>{{ $medico->cui }}</td>
                    <td>{{ $medico->especialidad }}</td>
                    <td>{{ $medico->telefono }}</td>
                    <td>{{ $medico->correo }}</td>
                    <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editMedicoModal-{{ $medico->id }}"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(event, {{ $medico->id }})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>

                <!-- Modal para Editar Médico -->
                <div class="modal fade" id="editMedicoModal-{{ $medico->id }}" tabindex="-1" role="dialog" aria-labelledby="editMedicoModalLabel-{{ $medico->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMedicoModalLabel-{{ $medico->id }}">Editar Médico</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('medicos.update', $medico->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" value="{{ $medico->nombre }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cui">CUI</label>
                                        <input type="text" name="cui" class="form-control" value="{{ $medico->cui }}" maxlength="13">
                                    </div>
                                    <div class="form-group">
                                        <label for="especialidad">Especialidad</label>
                                        <input type="text" name="especialidad" class="form-control" value="{{ $medico->especialidad }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ $medico->telefono }}" maxlength="8" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo Electrónico</label>
                                        <input type="email" name="correo" class="form-control" value="{{ $medico->correo }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Confirmación de eliminación con SweetAlert -->
                <form id="delete-form-{{ $medico->id }}" action="{{ route('medicos.destroy', $medico->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            @endforeach
        </tbody>
    </table>
</div>

<!-- Confirmación de eliminación con SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, medicoId) {
        event.preventDefault(); 
        Swal.fire({
            title: '¿Está seguro que quiere eliminar este médico?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + medicoId).submit(); 
            }
        });
    }
</script>
@endsection