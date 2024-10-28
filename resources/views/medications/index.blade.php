@extends('layouts.layout')

@section('title', 'Inventario de Medicamentos')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f0f2f5;
    }
    .container {
        margin-top: 50px;
    }
    h1 {
        color: #343a40;
        font-weight: 600;
        text-align: center;
        margin-bottom: 30px;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    .table {
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #007bff;
        color: white;
    }
    .modal-header {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="container">
    <h1>Inventario de Medicamentos</h1>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createMedicationModal">Agregar Medicamento</button>

    <form action="{{ route('medications.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar Medicamento o Código..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered" id="medicationsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Fecha de Caducidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medications as $medication)
                <tr class="{{ $medication->fecha_caducidad < now()->addMonth() ? 'table-warning' : '' }}">
                    <td>{{ $medication->id }}</td>
                    <td>{{ $medication->nombre }}</td>
                    <td>{{ $medication->descripcion }}</td>
                    <td>{{ $medication->codigo }}</td>
                    <td>{{ $medication->cantidad }}</td>
                    <td>{{ $medication->fecha_caducidad->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('medications.edit', $medication->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-form-{{ $medication->id }}" action="{{ route('medications.destroy', $medication->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, {{ $medication->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $medications->links('pagination::bootstrap-4') }}

    <div class="modal fade" id="createMedicationModal" tabindex="-1" role="dialog" aria-labelledby="createMedicationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMedicationModalLabel">Agregar Medicamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createMedicationForm" action="{{ route('medications.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="fecha_caducidad">Fecha de Caducidad</label>
                            <input type="date" name="fecha_caducidad" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div> <!-- Fin de la container -->

<!-- Confirmación de eliminación con SweetAlert -->
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Evitar el envío automático del formulario

        Swal.fire({
            title: '¿Está seguro que quiere eliminar este medicamento?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit(); // Envía el formulario si el usuario confirma
            }
        });
    }
</script>
@endsection

