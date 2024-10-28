@extends('layouts.layout')

@section('title', 'Crear Historial')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-primary">Crear Historial Clínico</h1>

        <form action="{{ route('medical_histories.store') }}" method="POST" class="mt-4 p-4 rounded shadow bg-white border border-primary">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            
            <!-- Datos Generales del Paciente -->
            <div class="mb-4">
                <h5 class="text-secondary mb-3" style="color: #007bff;">Datos Generales del Paciente</h5>
                <div class="card p-3 shadow-sm" style="border: 2px solid #007bff;">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="fw-bold">Número de Expediente:</span>
                            <span class="text-muted">{{ $patient->nexpedientes }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">CUI:</span>
                            <span class="text-muted">{{ $patient->cui }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Nombre Completo:</span>
                            <span class="text-muted">{{ $patient->primer_nombre }} {{ $patient->segundo_nombre }} {{ $patient->primer_apellido }} {{ $patient->segundo_apellido }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Apellido de Casada:</span>
                            <span class="text-muted">{{ $patient->apellido_casada }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Sexo:</span>
                            <span class="text-muted">{{ $patient->gender === 'masculino' ? 'Masculino' : 'Femenino' }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Fecha de Nacimiento:</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($patient->fecha_nacimiento)->format('d/m/Y') }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Edad:</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($patient->fecha_nacimiento)->age }} años</span>
                        </li>
                        <li class="mb-2">
                            <span class="fw-bold">Discapacidad:</span>
                            <span class="text-muted">{{ !empty($patient->discapacidad) ? $patient->discapacidad : 'No' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tipo de consulta -->
            <div class="mb-3">
                <label for="type_consult" class="form-label" style="color: #007bff;">Tipo de Consulta</label>
                <select name="type_consult" class="form-select" required>
                    <option value="primera consulta">Primera Consulta</option>
                    <option value="consulta general">Consulta General</option>
                </select>
            </div>

            <!-- Motivo de Consulta -->
            <div class="mb-3">
                <label for="consultation_reason" class="form-label" style="color: #007bff;">Motivo de Consulta</label>
                <textarea id="consultation_reason" name="consultation_reason" class="form-control" rows="3" required>{{ old('consultation_reason') }}</textarea>
            </div>

            <!-- Historia de la Enfermedad Actual -->
            <div class="mb-3">
                <label for="current_illness_history" class="form-label" style="color: #007bff;">Historia de la Enfermedad Actual</label>
                <textarea id="current_illness_history" name="current_illness_history" class="form-control" rows="3" required>{{ old('current_illness_history') }}</textarea>
            </div>

            <h5 class="text-secondary" style="color: #007bff;">Antecedentes</h5>
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Tipo</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Medicos</td>
                        <td>
                            <textarea id="personal_history" name="personal_history" class="form-control" rows="2" required>{{ old('personal_history') }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Quirúrgicos</td>
                        <td>
                            <textarea id="family_history" name="family_history" class="form-control" rows="2" required>{{ old('family_history') }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Vicios y Manías</td>
                        <td>
                            <textarea id="habits_history" name="habits_history" class="form-control" rows="2" required>{{ old('habits_history') }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Alergias</td>
                        <td>
                            <textarea id="allergies" name="allergies" class="form-control" rows="2" required>{{ old('allergies') }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h5 class="text-secondary" style="color: #007bff;">Examen Físico</h5>
            <table class="table table-bordered table-hover">
                <tbody>
                    <tr>
                        <td>
                            <label for="vital_signs" class="form-label" style="color: #007bff;">Signos Vitales</label>
                            <textarea id="vital_signs" name="vital_signs" class="form-control" rows="2" required>{{ old('vital_signs') }}</textarea>
                        </td>
                        <td>
                            <label for="weight" class="form-label" style="color: #007bff;">Peso (lb)</label>
                            <input type="number" name="weight" step="0.01" class="form-control" value="{{ old('weight') }}" required>
                        </td>
                        <td>
                            <label for="height" class="form-label" style="color: #007bff;">Altura (cm)</label>
                            <input type="number" name="height" step="0.01" class="form-control" value="{{ old('height') }}" required>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Diagnóstico y Tratamiento -->
            <div class="mb-3">
                <label for="diagnosis_treatment" class="form-label" style="color: #007bff;">Diagnóstico y Tratamiento</label>
                <textarea id="diagnosis_treatment" name="diagnosis_treatment" class="form-control" rows="3" required>{{ old('diagnosis_treatment') }}</textarea>
            </div>

            <!-- Comentarios -->
            <div class="mb-3">
                <label for="comments" class="form-label" style="color: #007bff;">Comentarios</label>
                <textarea id="comments" name="comments" class="form-control" rows="3" required>{{ old('comments') }}</textarea>
            </div>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save fa-lg"></i> Guardar
                </button>
                <a href="{{ route('medical_histories.index') }}" class="btn btn-danger btn-lg" style="background-color: #dc3545; border-color: #dc3545; border-radius: 50%; padding: 15px; transition: background-color 0.3s, transform 0.3s;">
                    <i class="fas fa-times fa-lg"></i> Cancelar
                </a>
            </div>

        </form>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/2qic79wlju1dc8wellsulukftwqpojtm60jgu1rgmkxfjxe1/tinymce/6.3.1/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        $(document).ready(function() {
        tinymce.init({
            selector: '#consultation_reason, #current_illness_history, #diagnosis_treatment, #comments', // Selecciona los textarea específicos
            plugins: 'link code',
                toolbar: 'undo redo | styleselect | bold italic | link',
                height: 200,
            });

              // Inicializa Select2 si se usa en otro lugar
        });
        $('form').on('submit', function(event) {
            console.log("Formulario enviado");
            $(this).find(':submit').attr('disabled', 'disabled');
        });
        
    </script>
@endsection