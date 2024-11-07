@extends('layouts.layout')

@section('title', 'Editar Inmunización')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary">Editar Inmunización</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inmunizaciones.update', $inmunizacion->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $inmunizacion->paciente_id }}">
        <input type="hidden" id="medico_id" name="medico_id" value="{{ $inmunizacion->medico_id }}">

        <div class="form-group">
            <label for="paciente_id">Paciente</label>
            <div class="form-row align-items-center">
                <div class="col">
                    <input type="text" id="paciente_nombre" class="form-control" value="{{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->primer_apellido }}" readonly>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-info mt-4" data-toggle="modal" data-target="#buscarPacienteModal">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="vacuna_id">Vacuna</label>
                <select name="vacuna_id" id="vacuna_id" class="form-control" required>
                    <option value="">Seleccione una vacuna</option>
                    @foreach ($vacunas as $vacuna)
                        <option value="{{ $vacuna->id }}" {{ $vacuna->id == $inmunizacion->vacuna_id ? 'selected' : '' }}>{{ $vacuna->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="dosis_id">Dosis</label>
                <select name="dosis_id" id="dosis_id" class="form-control" required>
                    <option value="">Seleccione una dosis</option>
                    @foreach ($dosis as $d)
                        <option value="{{ $d->id }}" {{ $d->id == $inmunizacion->dosis_id ? 'selected' : '' }}>{{ $d->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="fecha_vacunacion">Fecha de Inmunización</label>
            <input type="date" name="fecha_vacunacion" id="fecha_vacunacion" class="form-control" value="{{ $inmunizacion->fecha_vacunacion->format('Y-m-d') }}" required>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary w-100 mr-2">Actualizar</button>
            <a href="{{ route('inmunizaciones.index') }}" class="btn btn-secondary w-100">Cancelar</a>
        </div>
    </form>
</div>

<!-- Modal para Buscar Paciente -->
<div class="modal fade" id="buscarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="buscarPacienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buscarPacienteModalLabel">Buscar Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="search_paciente" class="form-control mb-3" placeholder="Buscar por nombre, apellido, CUI, expediente">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CUI</th>
                            <th>Nombre Completo</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="patient-table-body">
                        @forelse($pacientes as $paciente)
                            <tr>
                                <td>{{ $paciente->id }}</td>
                                <td>{{ $paciente->cui }}</td>
                                <td>{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</td>
                                <td>{{ $paciente->edad }}</td>
                                <td>
                                    <button class="btn btn-success agregar-paciente" 
                                            data-id="{{ $paciente->id }}" 
                                            data-nombre="{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron pacientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $pacientes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.agregar-paciente', function(event) {
            event.preventDefault();
            const paciente = $(this).data();

            $('#paciente_id').val(paciente.id);
            $('#paciente_nombre').val(paciente.nombre);

            $('#buscarPacienteModal').modal('hide');
            $('.modal-backdrop').remove();
        });

        $('#search_paciente').on('input', function() {
            const searchValue = $(this).val().toLowerCase();
            $('#patient-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
            });
        });

        $('#vacuna_id').on('change', function() {
            let vacunaId = $(this).val();
            $('#dosis_id').empty().append('<option value="">Seleccione una dosis</option>');
            
            if (vacunaId) {
                $.ajax({
                    url: '{{ route("inmunizaciones.mostrarDosis") }}',
                    type: 'POST',
                    data: {
                        vacuna_id: vacunaId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        data.forEach(function(dosis) {
                            $('#dosis_id').append('<option value="' + dosis.id + '">' + dosis.nombre + '</option>');
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al obtener las dosis:", error);
                    }
                });
            }
        });
    });
</script>

<style>
    body {
        background-color: #f8f9fa;
    }
    
    .container {
        max-width: 600px;
        margin: 0 auto;
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
        font-weight: bold;
        color: #343a40;
    }

    .btn {
        font-size: 1.2rem;
        padding: 10px 15px;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary:hover {
        background-color: #6c757d;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-footer {
        border-top: none;
    }

    h1 {
        color: #007bff;
    }
</style>

@endsection