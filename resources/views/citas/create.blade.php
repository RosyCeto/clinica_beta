@extends('layouts.layout')

@section('title', 'Agregar Cita')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Agregar Cita</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('citas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="paciente_id">Paciente</label>
            <div class="input-group">
                <input type="text" id="paciente_nombre" class="form-control" placeholder="Nombre del Paciente" readonly>
                <input type="hidden" id="paciente_id" name="paciente_id">
                <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#buscarPacienteModal">Buscar Paciente</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="medico_id">Médico</label>
            <div class="input-group">
                <input type="text" id="medico_nombre" class="form-control" placeholder="Nombre del Médico" readonly>
                <input type="hidden" id="medico_id" name="medico_id">
                <div class="input-group-append">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#buscarMedicoModal">Buscar Médico</button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" name="fecha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Cita</button>
        <a href="{{ route('citas.index') }}" class="btn btn-secondary">Volver</a>
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
                <input type="text" id="search_paciente" class="form-control" placeholder="Buscar por nombre, apellido, CUI, expediente">
                <br>
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
                                            data-nombre="{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}" 
                                            data-edad="{{ $paciente->edad }}">
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

<!-- Modal para Buscar Médico -->
<div class="modal fade" id="buscarMedicoModal" tabindex="-1" role="dialog" aria-labelledby="buscarMedicoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buscarMedicoModalLabel">Buscar Médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" id="search_medico" class="form-control" placeholder="Buscar por nombre o CUI">
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CUI</th>
                            <th>Nombre Completo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="medico-table-body">
                        @forelse($medicos as $medico)
                            <tr>
                                <td>{{ $medico->id }}</td>
                                <td>{{ $medico->cui }}</td>
                                <td>{{ $medico->nombre }}</td>
                                <td>
                                    <button class="btn btn-success agregar-medico" 
                                            data-id="{{ $medico->id }}" 
                                            data-nombre="{{ $medico->nombre }}">
                                        Agregar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No se encontraron médicos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $medicos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para Manejo de Búsqueda -->
<script>
    $(document).ready(function() {
        // Función para buscar pacientes
        $('#search_paciente').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#patient-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Función para buscar médicos
        $('#search_medico').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#medico-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

         // Manejar el clic en paciente
         $(document).on('click', '.agregar-paciente', function(event) {
            event.preventDefault();
            const paciente = $(this).data();
            
            $('#paciente_id').val(paciente.id);
            $('#paciente_cui').val(paciente.cui);
            $('#paciente_nombre').val(paciente.nombre);
    
            $('#buscarPacienteModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    
        // Manejar el clic en médico
        $(document).on('click', '.agregar-medico', function(event) {
            event.preventDefault();
            const medico = $(this).data();
            
            $('#medico_id').val(medico.id);
            $('#medico_cui').val(medico.cui);
            $('#medico_nombre').val(medico.nombre);
    
            $('#buscarMedicoModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    });
</script>

@endsection
