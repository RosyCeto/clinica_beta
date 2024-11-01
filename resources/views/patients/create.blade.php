@extends('layouts.layout')

@section('title', 'Crear Paciente')

@section('content')
<div class="text-center mb-4">
    <h1 class="display-4 text-success font-weight-bold">Crear Paciente</h1>
</div>

    <br>
    <br>


    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="form-row justify-content-center mb-3">
            <!-- Número de Expediente -->
            <div class="col-md-4 mb-3">
                <label for="nexpedientes">Número de Expediente:</label>
                <input type="text" name="nexpedientes" class="form-control" id="nexpedientes" placeholder="Ingrese el número de expediente" required>
            </div>
            

            <div class="col-md-4 mb-3">
    <label for="cui">CUI:</label>
    <input type="text" name="cui" class="form-control" id="cui" placeholder="Ingrese número de DPI" minlength="13" maxlength="13" pattern="\d{13}" title="El CUI debe contener exactamente 13 dígitos" required>
</div>

            
            
            <!-- Primer Nombre -->
            <div class="col-md-4 mb-3">
                <label for="primer_nombre">Primer Nombre:</label>
                <input type="text" name="primer_nombre" class="form-control" id="primer_nombre" placeholder="Ingrese el primer nombre" required>
            </div>
        </div>
        <!-- Fila para Nombres y Apellidos Alineados -->
        <div class="form-row justify-content-center mb-3">
            <!-- Segundo Nombre -->
            <div class="col-md-3 mb-3">
                <label for="segundo_nombre">Segundo Nombre:</label>
                <input type="text" name="segundo_nombre" class="form-control" id="segundo_nombre" placeholder="Ingrese segundo nombre">
            </div>
        
            <!-- Primer Apellido -->
            <div class="col-md-3 mb-3">
                <label for="primer_apellido">Primer Apellido:</label>
                <input type="text" name="primer_apellido" class="form-control" id="primer_apellido" placeholder="Ingrese primer apellido" required>
            </div>
        
            <!-- Segundo Apellido -->
            <div class="col-md-3 mb-3">
                <label for="segundo_apellido">Segundo Apellido:</label>
                <input type="text" name="segundo_apellido" class="form-control" id="segundo_apellido">
            </div>

            <!-- Apellido de Casada -->
            <div class="col-md-3 mb-3">
                <label for="apellido_casada">Apellido de Casada:</label>
                <input type="text" name="apellido_casada" class="form-control" id="apellido_casada">
            </div>
        </div>

        <div class="form-row justify-content-center mb-3">
            <!-- Sexo -->
            <div class="col-md-5 mb-3 text-center">
                <label for="gender" class="form-label">Sexo:</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" id="masculino" name="gender" value="masculino" class="form-check-input" required>
                    <label for="masculino" class="form-check-label">Masculino</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="femenino" name="gender" value="femenino" class="form-check-input" required>
                    <label for="femenino" class="form-check-label">Femenino</label>
                </div>
            </div>
        
            <!-- Etnia -->
            <div class="col-md-5 mb-3 text-center">
                <label for="etnia" class="form-label">Etnia:</label><br>
                <div class="form-check form-check-inline">
                    <input type="radio" id="ladina" name="etnia" value="ladina" class="form-check-input" required>
                    <label for="ladina" class="form-check-label">Ladina</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="maya" name="etnia" value="maya" class="form-check-input" required>
                    <label for="maya" class="form-check-label">Maya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="xinca" name="etnia" value="xinca" class="form-check-input" required>
                    <label for="xinca" class="form-check-label">Xinca</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="garifuna" name="etnia" value="garifuna" class="form-check-input" required>
                    <label for="garifuna" class="form-check-label">Garífuna</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="other" name="etnia" value="other" class="form-check-input" required>
                    <label for="other" class="form-check-label">Otro</label>
                </div>
            </div>
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

        

<div class="form-row justify-content-center align-items-end mb-3">
    <!-- Fecha de Nacimiento -->
    <div class="col-md-4 mb-3 text-center">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
    </div>

    <!-- Botón para Calcular -->
    <div class="col-md-2 mb-3 text-center">
        <button type="button" class="btn btn-primary" onclick="calcularEdad()" title="Calcular Edad">
            <i class="fas fa-calculator"></i> <!-- Ícono de calculadora -->
        </button>
    </div>

    <!-- Edad -->
    <div class="col-md-4 mb-3 text-center">
        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" class="form-control" readonly>
    </div>
</div>

<script>
    function calcularEdad() {
        var fechaNacimiento = document.getElementById("fecha_nacimiento").value;
        if (!fechaNacimiento) {
            alert("Por favor, ingresa una fecha de nacimiento.");
            return;
        }

        var hoy = new Date();
        var nacimiento = new Date(fechaNacimiento);

        var edadAnios = hoy.getFullYear() - nacimiento.getFullYear();
        var edadMeses = hoy.getMonth() - nacimiento.getMonth();
        var edadDias = hoy.getDate() - nacimiento.getDate();

        // Ajustar los meses y días si es necesario
        if (edadDias < 0) {
            edadMeses--;
            edadDias += new Date(hoy.getFullYear(), hoy.getMonth(), 0).getDate();
        }

        if (edadMeses < 0) {
            edadAnios--;
            edadMeses += 12;
        }

        // Formatear la edad como "X años, Y meses, Z días"
        var edadCompleta = edadAnios + " años, " + edadMeses + " meses, " + edadDias + " días";

        // Mostrar la edad en el campo correspondiente
        document.getElementById("edad").value = edadCompleta;
    }
</script>

        
<div class="form-row mb-3 justify-content-center">
    <!-- Discapacidad -->
    <div class="col-md-6 mb-3">
        <label for="discapacidad">Discapacidad:</label>
        <div class="d-flex align-items-center">
            <div class="form-check form-check-inline">
                <input type="checkbox" id="ninguna" name="discapacidad[]" value="ninguna" class="form-check-input">
                <label for="ninguna" class="form-check-label">N/A</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="fisica" name="discapacidad[]" value="fisica" class="form-check-input">
                <label for="fisica" class="form-check-label">Física</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="mental" name="discapacidad[]" value="mental" class="form-check-input">
                <label for="mental" class="form-check-label">Mental</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="visual" name="discapacidad[]" value="visual" class="form-check-input">
                <label for="visual" class="form-check-label">Visual</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="auditiva" name="discapacidad[]" value="auditiva" class="form-check-input">
                <label for="auditiva" class="form-check-label">Auditiva</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="checkbox" id="otra" name="discapacidad[]" value="otra" class="form-check-input">
                <label for="otra" class="form-check-label">Otra</label>
            </div>
        </div>
    </div>

    <!-- Escolaridad -->
    <div class="col-md-6 mb-3">
        <label for="escolaridad" class="form-label">Escolaridad</label><br>
        <div class="form-check form-check-inline">
            <input type="radio" id="preprimaria" name="escolaridad" value="preprimaria" class="form-check-input">
            <label for="preprimaria" class="form-check-label">Pre-primaria</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="primaria" name="escolaridad" value="primaria" class="form-check-input">
            <label for="primaria" class="form-check-label">Primaria</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="basico" name="escolaridad" value="basico" class="form-check-input">
            <label for="basico" class="form-check-label">Básico</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="diversificado" name="escolaridad" value="diversificado" class="form-check-input">
            <label for="diversificado" class="form-check-label">Diversificado</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="universidad" name="escolaridad" value="universidad" class="form-check-input">
            <label for="universidad" class="form-check-label">Universidad</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="otro" name="escolaridad" value="otro" class="form-check-input">
            <label for="otro" class="form-check-label">Otro</label>
        </div>
        <div class="form-check form-check-inline">
            <input type="radio" id="no_indica" name="escolaridad" value="N/A" class="form-check-input">
            <label for="no_indica" class="form-check-label">No indica</label>
        </div>
        @if ($errors->has('escolaridad'))
            <span class="text-danger">{{ $errors->first('escolaridad') }}</span>
        @endif
    </div>
</div>

<!-- Fila para Profesión, Teléfono y Dirección Alineados -->
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label for="profesion">Profesión:</label>
        <input type="text" name="profesion" class="form-control" placeholder="Ingrese profesión">
    </div>
   
    <div class="col-md-4 mb-3">
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ingrese número de teléfono" maxlength="8" pattern="\d{8}" title="El número de teléfono debe tener exactamente 8 dígitos." required> 
    </div>
    

    <div class="col-md-4 mb-3">
        <label for="address">Dirección:</label>
        <input type="text" name="direccion" class="form-control" placeholder="Ingrese dirección exacta" required>
    </div>
</div>

      
        
<div class="container mb-4 text-center"> <!-- Agrega mb-4 para margen inferior y text-center para centrar el contenido -->
    <!-- Tu formulario aquí -->
    
    <button type="submit" class="btn btn-success btn-lg mt-3">
        <i class="fas fa-user-plus"></i> <!-- Icono de Font Awesome -->
        Crear Paciente
    </button>
</div>


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

    <script>
        document.getElementById('contact-search').addEventListener('input', function() {
            const query = this.value;
            const resultsContainer = document.getElementById('contact-results');

            if (query.length > 2) { // Comenzar a buscar después de 2 caracteres
                fetch(/patients/search?query=${query})
                    .then(response => response.json())
                    .then(data => {
                        resultsContainer.innerHTML = ''; // Limpiar resultados anteriores
                        resultsContainer.style.display = 'block'; // Mostrar la lista de resultados

                        data.forEach(patient => {
                            const li = document.createElement('li');
                            li.className = 'list-group-item';
                            li.textContent = ${patient.full_name} - ${patient.cui};
                            li.dataset.id = patient.id;

                            li.addEventListener('click', function() {
                                document.getElementById('contact-search').value = patient.full_name; // Mostrar nombre en el input
                                document.getElementById('contact_id').value = patient.id; // Guardar el ID del contacto
                                resultsContainer.style.display = 'none'; // Ocultar resultados
                            });

                            resultsContainer.appendChild(li);
                        });
                    });
            } else {
                resultsContainer.innerHTML = ''; // Limpiar resultados si la consulta es muy corta
                resultsContainer.style.display = 'none'; // Ocultar resultados
            }
        });
    </script>
@endsection