@extends('layouts.layout')

@section('title', 'Inventario de Medicamentos')

@section('content')
<style>
    body {
        background-color: #f3f4f6; 
        font-family: 'Arial', sans-serif;
        color: #333;
    }
    .container {
        margin-top: 30px;
        padding: 20px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #6c757d; 
        margin-bottom: 20px;
        font-size: 24px;
        text-align: center;
    }
    .btn {
        border-radius: 5px;
        transition: transform 0.2s, background-color 0.3s;
        font-weight: bold;
    }
    .btn-primary {
        background-color: #28a745; 
        border: none;
    }
    .btn-primary:hover {
        background-color: #218838; 
        transform: scale(1.05);
    }
    .btn-secondary {
        background-color: #ffc107; 
        border: none;
    }
    .btn-secondary:hover {
        background-color: #e0a800; 
        transform: scale(1.05);
    }
    .table {
        margin-top: 20px;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #28a745; 
        color: white;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9; 
    }
    .modal-header {
        background-color: #f7f7f7; 
    }
    .modal-title {
        color: #28a745; 
    }
    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da; 
    }
    .alert {
        border-radius: 5px;
    }
</style>

<div class="container">
    <h1>Inventario de Medicamentos</h1>

    <div class="mb-3 text-center">
        <button class="btn btn-primary" data-toggle="modal" data-target="#createMedicationModal">
            <i class="fas fa-plus"></i> Agregar Medicamento
        </button>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#createSaleModal">
            <i class="fas fa-sign-out-alt"></i> Salida de Medicamento
        </button>
    </div>

    <form action="{{ route('medications.index') }}" method="GET" class="search-bar">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Buscar Medicamento por Nombre o Código..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" aria-label="Buscar">
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

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Código</th>
                <th>Cantidad</th>
                <th>Fecha de Ingreso</th>
                <th>Fecha de Caducidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($medications as $medication)
                <tr class="{{ $medication->fecha_caducidad < now()->addMonth() ? 'table-warning' : '' }}">
                    <td>{{ $medication->nombre }}</td>
                    <td>{{ $medication->descripcion }}</td>
                    <td>{{ $medication->codigo }}</td>
                    <td>{{ $medication->cantidad }}</td>
                    <td>{{ $medication->fecha_ingreso->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($medication->fecha_caducidad)->format('d-m-Y') }}</td>
                <td>
                    <a href="{{ route('medications.edit', $medication->id) }}" class="btn btn-warning btn-icon" title="Editar Medicamento">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form id="delete-form-{{ $medication->id }}" action="{{ route('medications.destroy', $medication->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-icon" onclick="confirmDelete(event, {{ $medication->id }})" title="Eliminar Medicamento">
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
                            <input type="text" name="nombre" class="form-control" required placeholder="Nombre del medicamento">
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" placeholder="Descripción del medicamento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" required placeholder="Código del medicamento">
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" required min="1" placeholder="Cantidad disponible">
                        </div>
                        <div class="form-group">
                            <label for="fecha_ingreso">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" class="form-control" required>
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
                            <label for="medication_id">Buscar Medicamento</label>
                            <input type="text" id="medicationSearch" class="form-control mb-2" placeholder="Buscar por Nombre, o Código..." oninput="filterMedications()">
                            <select name="medication_id" id="medicationSelect" class="form-control" required onchange="updateFechaIngreso()">
                                <option value="" disabled selected>Seleccione un medicamento</option>
                                @foreach ($medications as $medication)
                                    <option value="{{ $medication->id }}"
                                            data-cantidad="{{ $medication->cantidad }}"
                                            data-fecha-ingreso="{{ $medication->fecha_ingreso }}"
                                            data-fecha-caducidad="{{ $medication->fecha_caducidad }}">
                                        {{ $medication->nombre }} (ID: {{ $medication->id }}, Cantidad: {{ $medication->cantidad }}, Código: {{ $medication->codigo }})
                                    </option>
                                @endforeach
                            </select>
                            
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad a Retirar</label>
                            <input type="number" name="cantidad" class="form-control" required min="1" placeholder="Cantidad a retirar">
                        </div>
                        <div class="form-group">
                            <label for="fechaIngreso">Fecha de Ingreso</label>
                            <input type="text" id="fechaIngreso" class="form-control" readonly>
                        </div>
    
                        <div class="form-group">
                            <label for="fechaCaducidad">Fecha de Caducidad</label>
                            <input type="text" id="fechaCaducidad" class="form-control" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar Salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este medicamento? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteFormId;

    function confirmDelete(event, id) {
        event.preventDefault();
        deleteFormId = id; 
        $('#confirmDeleteModal').modal('show'); 
    }

    document.getElementById('confirmDeleteButton').onclick = function() {
        document.getElementById('delete-form-' + deleteFormId).submit(); 
    };

    function filterMedications() {
        const searchValue = document.getElementById('medicationSearch').value.toLowerCase();
        const options = document.querySelectorAll('#medicationSelect option');

        options.forEach(option => {
            const text = option.textContent.toLowerCase();
            option.style.display = text.includes(searchValue) ? 'block' : 'none';
        });

    
        if (!Array.from(options).some(option => option.selected && option.style.display !== 'none')) {
            document.getElementById('medicationSelect').selectedIndex = 0;
        }
    }

    function updateFechaIngreso() {
        var select = document.getElementById('medicationSelect');
        var selectedOption = select.options[select.selectedIndex];
        
      
        var fechaIngreso = selectedOption.getAttribute('data-fecha-ingreso');
        var fechaCaducidad = selectedOption.getAttribute('data-fecha-caducidad');
        
      
        document.getElementById('fechaIngreso').value = formatDate(fechaIngreso); 
        document.getElementById('fechaCaducidad').value = formatDate(fechaCaducidad); 
    }
    
  
    function formatDate(dateString) {
        var date = new Date(dateString);
        var year = date.getFullYear();
        var month = ('0' + (date.getMonth() + 1)).slice(-2); 
        var day = ('0' + date.getDate()).slice(-2);
    
        return day + '-' + month + '-' + year; 
    }
    
   
        function formatDate(dateString) {
            var date = new Date(dateString);
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2); 
            var day = ('0' + date.getDate()).slice(-2);
    
            return day + '-' + month + '-' + year; 
        }
</script>
@endsection