@extends('layouts.layout')

@section('title', 'Editar Paciente')

@section('content')

<div class="text-center mb-4">
    <h1 class="display-4 text-success font-weight-bold">Editar Paciente</h1>
    <p class="lead">Modifica la información del paciente a continuación y guarda los cambios.</p>
</div>

    <br>
    <br>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group row">
            <div class="col-sm-4">
                <label for="nexpedientes" class="col-form-label">Número de Expedientes:</label>
                <input type="text" name="nexpedientes" class="form-control" value="{{ old('nexpedientes', $patient->nexpedientes) }}" required>
            </div>
            <div class="col-sm-4">
                <label for="cui" class="col-form-label">CUI:</label>
                <input type="text" name="cui" class="form-control" maxlength="13" value="{{ old('cui', $patient->cui) }}">
            </div>            
            <div class="col-sm-4">
                <label for="primer_nombre">Primer Nombre:</label>
                <input type="text" name="primer_nombre" class="form-control" value="{{ old('primer_nombre', $patient->primer_nombre) }}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-3">
                <label for="segundo_nombre">Segundo Nombre:</label>
                <input type="text" name="segundo_nombre" class="form-control" value="{{ old('segundo_nombre', $patient->segundo_nombre) }}">
            </div>            
            <div class="col-sm-3">
                <label for="primer_apellido">Primer Apellido:</label>
                <input type="text" name="primer_apellido" class="form-control" value="{{ old('primer_apellido', $patient->primer_apellido) }}" required>
            </div>
            <div class="col-sm-3">
                <label for="segundo_apellido">Segundo Apellido:</label>
                <input type="text" name="segundo_apellido" class="form-control" value="{{ old('segundo_apellido', $patient->segundo_apellido) }}">
            </div>
            <div class="col-sm-3">
                <label for="apellido_casada">Apellido de Casada:</label>
                <input type="text" name="apellido_casada" class="form-control" value="{{ old('apellido_casada', $patient->apellido_casada) }}">
            </div>
        </div>
        

        <div class="form-group row">
            <div class="col-sm-6">
                <label for="gender">Sexo:</label>
                <select name="gender" class="form-control" required>
                    <option value="masculino" {{ old('gender', $patient->gender) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="femenino" {{ old('gender', $patient->gender) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>
            <div class="col-sm-6">
                <label for="etnia">Étnia:</label>
                <select name="etnia" class="form-control" required>
                    <option value="ladina" {{ old('etnia', $patient->etnia) == 'ladina' ? 'selected' : '' }}>Ladina</option>
                    <option value="maya" {{ old('etnia', $patient->etnia) == 'maya' ? 'selected' : '' }}>Maya</option>
                    <option value="xinca" {{ old('etnia', $patient->etnia) == 'xinca' ? 'selected' : '' }}>Xinca</option>
                    <option value="garifuna" {{ old('etnia', $patient->etnia) == 'garifuna' ? 'selected' : '' }}>Garífuna</option>
                    <option value="otro" {{ old('etnia', $patient->etnia) == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-6">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" name="fecha_nacimiento" class="form-control" 
                       value="{{ old('fecha_nacimiento', $patient->fecha_nacimiento) }}" 
                       required onchange="calculateAge()">
            </div>
            <div class="col-sm-6">
                <label for="edad">Edad:</label>
                <input type="text" name="edad" id="edad" class="form-control" 
                       value="{{ old('edad', $patient->edad) }}" required readonly>
            </div>
        </div>
        
        <script>
        function calculateAge() {
            const fechaNacimientoInput = document.querySelector('input[name="fecha_nacimiento"]');
            const edadInput = document.getElementById('edad');
        
            const fechaNacimiento = new Date(fechaNacimientoInput.value);
            const hoy = new Date();
        
            
            let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            const mesDiff = hoy.getMonth() - fechaNacimiento.getMonth();
            const diaDiff = hoy.getDate() - fechaNacimiento.getDate();
        
          
            if (mesDiff < 0 || (mesDiff === 0 && diaDiff < 0)) {
                edad--;
            }
        
            let meses = (mesDiff + 12) % 12; 
            if (diaDiff < 0) {
                meses = (meses + 11) % 12; 
            }
        
      
            let dias = (diaDiff + 30) % 30; 
        
        
            edadInput.value = `${edad} años, ${meses} meses, ${dias} días`;
        }
        </script>
        
        
        <div class="form-group row">
            <div class="col-sm-6">
                <label for="discapacidad">Discapacidad:</label><br>
                <div class="d-flex flex-wrap">
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="na" name="discapacidad[]" value="N/A" 
                               class="form-check-input" 
                               {{ in_array('N/A', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="na" class="form-check-label">N/A</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="fisica" name="discapacidad[]" value="fisica" 
                               class="form-check-input" 
                               {{ in_array('fisica', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="fisica" class="form-check-label">Física</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="mental" name="discapacidad[]" value="mental" 
                               class="form-check-input" 
                               {{ in_array('mental', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="mental" class="form-check-label">Mental</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="visual" name="discapacidad[]" value="visual" 
                               class="form-check-input" 
                               {{ in_array('visual', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="visual" class="form-check-label">Visual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="auditiva" name="discapacidad[]" value="auditiva" 
                               class="form-check-input" 
                               {{ in_array('auditiva', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="auditiva" class="form-check-label">Auditiva</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="otra" name="discapacidad[]" value="otra" 
                               class="form-check-input" 
                               {{ in_array('otra', old('discapacidad', explode(',', $patient->discapacidad))) ? 'checked' : '' }}>
                        <label for="otra" class="form-check-label">Otra</label>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-6">
                <label for="escolaridad">Escolaridad:</label>
                <select name="escolaridad" class="form-control" required>
                    <option value="N/A" {{ old('escolaridad', $patient->escolaridad) == 'N/A' ? 'selected' : '' }}>N/A</option>
                    <option value="preprimaria" {{ old('escolaridad', $patient->escolaridad) == 'preprimaria' ? 'selected' : '' }}>Preprimaria</option>
                    <option value="primaria" {{ old('escolaridad', $patient->escolaridad) == 'primaria' ? 'selected' : '' }}>Primaria</option>
                    <option value="basico" {{ old('escolaridad', $patient->escolaridad) == 'basico' ? 'selected' : '' }}>Básico</option>
                    <option value="diversificado" {{ old('escolaridad', $patient->escolaridad) == 'diversificado' ? 'selected' : '' }}>Diversificado</option>
                    <option value="universidad" {{ old('escolaridad', $patient->escolaridad) == 'universidad' ? 'selected' : '' }}>Universidad</option>
                    <option value="otro" {{ old('escolaridad', $patient->escolaridad) == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>
        

        <div class="form-group row">
            <div class="col-sm-4">
                <label for="profesion">Profesión:</label>
                <input type="text" name="profesion" class="form-control" value="{{ old('profesion', $patient->profesion) }}">
            </div>
            <div class="col-sm-4">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" class="form-control" maxlength="8" value="{{ old('telefono', $patient->telefono) }}" required>
            </div>
            <div class="col-sm-4">
                <label for="direccion">Dirección:</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $patient->direccion) }}" required>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> 
            </button>
        </div>
        

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <script>
        function searchEmergencyContact(query) {
            fetch(`/search-patients?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('emergency_contact_id');
                    select.innerHTML = '';
                    data.forEach(contact => {
                        const option = document.createElement('option');
                        option.value = contact.id;
                        option.textContent = `${contact.nombre} ${contact.apellido}`;
                        select.appendChild(option);
                    });
                });
        }

        document.getElementById('search-input').addEventListener('input', (e) => {
            searchEmergencyContact(e.target.value);
        });
    </script>
@endsection