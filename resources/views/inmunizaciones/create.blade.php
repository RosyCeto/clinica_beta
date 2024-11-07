@extends('layouts.layout')

@section('title', 'Registrar Inmunización')

@section('content')
<div class="container">
    <h1>Registrar Inmunización</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('inmunizaciones.store') }}" method="POST">
        @csrf
        <input type="hidden" id="paciente_id" name="paciente_id">
        <input type="hidden" id="medico_id" name="medico_id">
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
        <div class="form-group">
            <label for="vacuna_id">Vacuna</label>
            <select name="vacuna_id" id="vacuna_id" class="form-control" required>
                <option value="">Seleccione una vacuna</option>
                @foreach ($vacunas as $vacuna)
                    <option value="{{ $vacuna->id }}">{{ $vacuna->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="dosis_id">Dosis</label>
            <select name="dosis_id" id="dosis_id" class="form-control" required>
                <option value="">Seleccione una dosis</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fecha_vacunacion">Fecha de Inmunización</label>
            <input type="date" name="fecha_vacunacion" id="fecha_vacunacion" class="form-control" required>
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
                    {{ $pacientes->links() }} <!-- Esto genera los enlaces de paginación -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para Manejo de Búsqueda y Dosis -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.agregar-paciente', function(event) {
            event.preventDefault();
            const paciente = $(this).data();

            $('#paciente_id').val(paciente.id);
            $('#paciente_cui').val(paciente.cui);
            $('#paciente_nombre').val(paciente.nombre);

            $('#buscarPacienteModal').modal('hide');
            $('.modal-backdrop').remove();
            $('#search_paciente').val('');
            $('#patient-table-body tr').show();
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
@endsection