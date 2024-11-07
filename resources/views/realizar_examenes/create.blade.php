@extends('layouts.layout')

@section('title', 'Registro Realizar Examen')

@section('content')
<div class="container">
    <h1>Registro Realizar Examen</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('realizar_examenes.store') }}" method="POST">
        @csrf
        <input type="hidden" id="paciente_id" name="paciente_id">
        <input type="hidden" id="medico_id" name="medico_id">

        <!-- Sección de Paciente -->
        <div class="form-group">
            <div class="form-row align-items-center">
                <div class="col">
                    <label for="paciente_cui">CUI del Paciente</label>
                    <input type="text" id="paciente_cui" class="form-control" placeholder="CUI" readonly>
                </div>
                <div class="col">
                    <label for="paciente_nombre">Nombre del Paciente</label>
                    <input type="text" id="paciente_nombre" class="form-control" placeholder="Nombre" readonly>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-info mt-4" data-toggle="modal" data-target="#buscarPacienteModal">Buscar Paciente</button>
                </div>
            </div>
        </div>

        <!-- Sección de Médico -->
        <div class="form-group">
            <div class="form-row align-items-center">
                <div class="col">
                    <label for="medico_cui">CUI del Médico</label>
                    <input type="text" id="medico_cui" class="form-control" placeholder="CUI" readonly>
                </div>
                <div class="col">
                    <label for="medico_nombre">Nombre del Médico</label>
                    <input type="text" id="medico_nombre" class="form-control" placeholder="Nombre" readonly>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-info mt-4" data-toggle="modal" data-target="#buscarMedicoModal">Buscar Médico</button>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="tipo_analisis_id">Tipo de Análisis</label>
            <select name="tipo_analisis_id" id="tipo_analisis_id" class="form-control" required>
                <option value="">Seleccione un tipo de análisis</option>
                @foreach ($tipos_analisis as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="examen_id">Examen</label>
            <select name="examen_id" id="examen_id" class="form-control" required>
                <option value="">Seleccione un examen</option>
                @foreach ($examenes as $examen)
                    <option value="{{ $examen->id }}">{{ $examen->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pendiente">Pendiente</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
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
                <input type="text" id="search_paciente" class="form-control" placeholder="Buscar por CUI, nombre o apellido">
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>CUI</th>
                            <th>Nombre Completo</th>
                            <th>Edad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="patient-table-body">
                        @forelse($pacientes as $paciente)
                            <tr>
                                <td>{{ $paciente->cui }}</td>
                                <td>{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</td>
                                <td>{{ $paciente->edad }}</td>
                                <td>
                                    <button class="btn btn-success agregar-paciente" 
                                            data-id="{{ $paciente->id }}" 
                                            data-cui="{{ $paciente->cui }}" 
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

                <!-- Agregar la paginación -->
                <div class="d-flex justify-content-center">
                    {{ $pacientes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Buscar Médico -->
<div class="modal fade" id="buscarMedicoModal" tabindex="-1" role="dialog" aria-labelledby="buscarMedicoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                            <th>CUI</th>
                            <th>Nombre Completo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="medico-table-body">
                        @forelse($medicos as $medico)
                            <tr>
                                <td>{{ $medico->cui }}</td>
                                <td>{{ $medico->nombre }}</td>
                                <td>
                                    <button class="btn btn-success agregar-medico" 
                                            data-id="{{ $medico->id }}" 
                                            data-cui="{{ $medico->cui }}" 
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
                <!-- Agregar la paginación -->
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
       
        $('#search_paciente').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#patient-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $('#search_medico').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#medico-table-body tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    
        
        $(document).on('click', '.agregar-paciente', function(event) {
            event.preventDefault();
            const paciente = $(this).data();
            
            $('#paciente_id').val(paciente.id);
            $('#paciente_cui').val(paciente.cui);
            $('#paciente_nombre').val(paciente.nombre);
    
            $('#buscarPacienteModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    

        $(document).on('click', '.agregar-medico', function(event) {
            event.preventDefault();
            const medico = $(this).data();
            
            $('#medico_id').val(medico.id);
            $('#medico_cui').val(medico.cui);
            $('#medico_nombre').val(medico.nombre);
    
            $('#buscarMedicoModal').modal('hide');
            $('.modal-backdrop').remove();
        });
    

        $('#tipo_analisis_id').on('change', function() {
            let tipoAnalisisId = this.value;
            fetch(`/search/examenes?tipo_analisis_id=${tipoAnalisisId}`)
                .then(response => response.json())
                .then(data => {
                    let examenSelect = $('#examen_id');
                    examenSelect.empty();
                    examenSelect.append('<option value="">Seleccione un examen</option>');
                    data.forEach(examen => {
                        examenSelect.append(`<option value="${examen.id}">${examen.nombre}</option>`);
                    });
                });
        });
    });  
            </script>
            @endsection