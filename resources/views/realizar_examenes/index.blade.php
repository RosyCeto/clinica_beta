@extends('layouts.layout')

@section('title', 'Lista de Exámenes Realizados')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Exámenes Realizados</h1>

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

    <div class="mb-3 text-right">
        <a href="{{ route('realizar_examenes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Registro
        </a>
    </div>

    <!-- Campo de búsqueda -->
    <form method="GET" class="mb-3">
        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar por ID, Usuario, Paciente o Médico" value="{{ request('search') }}">
    </form>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Usuario</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($realizarExamenes as $examen)
                <tr>
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
                        <a href="{{ route('realizar_examenes.edit', $examen->id) }}" class="btn btn-warning btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Formulario oculto para la eliminación -->
                        <form id="delete-form-{{ $examen->id }}" action="{{ route('realizar_examenes.destroy', $examen->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button class="btn btn-danger btn-sm" title="Eliminar" onclick="confirmDelete(event, {{ $examen->id }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($realizarExamenes->isEmpty())
        <div class="alert alert-info text-center">
            No hay exámenes registrados.
        </div>
    @else
        <div class="d-flex justify-content-between">
            {{ $realizarExamenes->links() }} <!-- Paginación -->
        </div>
    @endif

</div>

<!-- Confirmación de eliminación con SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, examenId) {
        event.preventDefault();
        Swal.fire({
            title: '¿Está seguro que quiere eliminar este examen?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + examenId).submit(); 
            }
        });
    }
</script>
@endsection