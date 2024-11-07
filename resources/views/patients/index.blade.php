@extends('layouts.layout')

@section('title', 'Lista de Pacientes')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Lista de Pacientes</h1>

    <!-- Mostrar mensaje de éxito solo una vez -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botón para agregar un nuevo paciente -->
    <div class="mb-3 text-end">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Paciente
        </a>
    </div>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('patients.index') }}" method="GET" class="mb-3" id="search-form">
        <div class="input-group">
            <input type="text" name="search" id="search-input" class="form-control" placeholder="Buscar paciente por CUI, número de expediente o nombre completo" value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Tabla de pacientes -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>CUI</th>
                    <th>Nº Expedientes</th>
                    <th>Nombre Completo</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Género</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="patient-table-body">
                @forelse($patients as $patient)
                    <tr>
                        <td>{{ $patient['cui'] }}</td>
                        <td>{{ $patient['nexpedientes'] }}</td>
                        <td>{{ $patient['full_name'] }}</td>
                        <td>{{ $patient['fecha_nacimiento'] }}</td>
                        <td>{{ $patient['gender'] }}</td>
                        <td class="text-center">
                            <a href="{{ route('patients.edit', $patient['id']) }}" class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('patients.destroy', $patient['id']) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <!-- Mostrar el botón de Historial Médico solo para roles admin y doctor -->
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'doctor')
        <a href="{{ route('medical_histories.create', $patient['id']) }}" class="btn btn-primary" title="Historial Médico">
            <i class="fas fa-file-medical"></i>
        </a>
    @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No se encontraron pacientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $patients->links() }} <!-- Paginación -->
    </div>
</div>

<!-- Script de búsqueda dinámica -->
<script>
document.getElementById('search-input').addEventListener('input', function() {
    const searchQuery = this.value;

    fetch(`{{ route('patients.index') }}?search=${searchQuery}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tbody = document.getElementById('patient-table-body');
        tbody.innerHTML = ''; 

        if (data.patients.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" class="text-center">No se encontraron pacientes.</td></tr>`;
        } else {
            data.patients.forEach(patient => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.cui}</td>
                    <td>${patient.nexpedientes}</td>
                    <td>${patient.full_name}</td>
                    <td>${patient.fecha_nacimiento}</td>
                    <td>${patient.gender}</td>
                    <td class="text-center">
                        <a href="/patients/${patient.id}/edit" class="btn btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                        <form action="/patients/${patient.id}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                        </form>
                        <a href="/medical_histories/create/${patient.id}" class="btn btn-primary" title="Historial Médico"><i class="fas fa-file-medical"></i></a>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    })
    .catch(error => console.error('Error al buscar pacientes:', error));
});
</script>

<!-- Confirmación de eliminación con SweetAlert -->
<script>
    function confirmDelete(event) {
        event.preventDefault(); 

        Swal.fire({
            title: '¿Está seguro que quiere eliminar este paciente?',
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
    body {
        background-color: #f8f9fa; 
    }
    .container {
        margin-top: 20px;
        background-color: #ffffff; 
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #e9ecef; 
    }
    .table td {
        vertical-align: middle; 
    }
    .btn {
        margin: 0 2px; 
    }
</style>
@endsection