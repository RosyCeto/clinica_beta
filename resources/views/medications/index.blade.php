@extends('layouts.layout')

@section('title', 'Inventario de Medicamentos')

@section('content')
<style>
    /* Estilos existentes */
</style>

<div class="container">
    <h1>Inventario de Medicamentos</h1>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createMedicationModal">Agregar Medicamento</button>
    <button class="btn btn-secondary mb-3" data-toggle="modal" data-target="#createSaleModal">Salida de Medicamento</button>

    <form action="{{ route('medications.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar Medicamento o Nombre..." value="{{ request('search') }}">
            <input type="text" name="code_search" class="form-control" placeholder="Buscar por Código..." value="{{ request('code_search') }}">
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

    <!-- Modal para Agregar Medicamento -->
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

    <!-- Modal para Salida de Medicamento -->
    <div class="modal fade" id="createSaleModal" tabindex="-1" role="dialog" aria-labelledby="createSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSaleModalLabel">Salida de Medicamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('medications.sale') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="medication_id">ID del Medicamento</label>
                            <select name="medication_id" class="form-control" required>
                                @foreach ($medications as $medication)
                                    <option value="{{ $medication->id }}">{{ $medication->nombre }} (ID: {{ $medication->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" required min="1">
                        </div>
                        <button type="submit" class="btn btn-secondary">Registrar Salida</button>
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
