<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Médico del Paciente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f7;
            font-size: 14px; /* Tamaño de letra ligeramente más grande */
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 24px; /* Título más grande */
        }
        .container {
            max-width: 100%;
            margin: 0;
            padding: 40px; /* Margen superior e inferior mayor */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100vh; /* Ocupa todo el alto de la hoja */
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px; /* Mayor separación en el encabezado */
        }
        .logo {
            width: 180px; /* Logo más grande */
            height: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra para el logo */
            border-radius: 5px; /* Bordes redondeados */
        }
        .expediente {
            text-align: right; /* Alinea el expediente a la derecha */
        }
        .expediente strong {
            font-size: 16px; /* Tamaño de fuente ajustado */
            color: #2c3e50;
        }
        .data-section {
            margin-top: 30px;
            line-height: 1.6; /* Espaciado mayor entre líneas */
            text-align: justify; /* Justifica el texto */
        }
        .data-section strong {
            color: #34495e;
        }
        /* Estilos de sombra y bordes para las secciones */
        .data-section {
            background-color: #f9fafb;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('plantilla/dist/img/salud.jpg') }}" alt="Logotipo MSPAS" class="logo">
            <div class="expediente">
                <strong>No. Expediente:</strong> {{ $patient->nexpedientes }}<br>
            </div>
        </div>
        <h1>Historial Médico del Paciente</h1>
        <div class="data-section">
            <strong>Datos Generales del Paciente</strong><br>
            CUI: {{ $patient->cui }}<br>
            Nombre Completo: {{ $patient->full_name }}<br>
            Apellido de Casada: {{ $patient->apellido_casada }}<br>
            Sexo: {{ $patient->gender }}<br>
            Fecha de Nacimiento: {{ $patient->fecha_nacimiento }}<br>
            Edad: {{ $patient->edad }} años<br>
            Discapacidad: {{ $patient->discapacidad ?? 'N/A' }}<br>
            <strong>Tipo de Consulta:</strong> {{ $medicalHistory->type_consult }}<br>
            <strong>Motivo de Consulta:</strong>
            @if(!empty(trim($medicalHistory->consultation_reason)))
                {{ strip_tags(html_entity_decode($medicalHistory->consultation_reason)) }}<br>
            @else
                N/A<br>
            @endif
            <strong>Historia de la Enfermedad Actual:</strong>
            @if(!empty(trim($medicalHistory->current_illness_history)))
                {{ strip_tags(html_entity_decode($medicalHistory->current_illness_history)) }}<br>
            @else
                N/A<br>
            @endif
            <strong>Historia Personal:</strong> {{ $medicalHistory->personal_history }}<br>
            <strong>Historia Familiar:</strong> {{ $medicalHistory->family_history }}<br>
            <strong>Historia de Hábitos:</strong> {{ $medicalHistory->habits_history }}<br>
            <strong>Alergias:</strong> {{ $medicalHistory->allergies }}<br>
            <strong>Signos Vitales:</strong> {{ $medicalHistory->vital_signs }}<br>
            <strong>Peso:</strong> {{ $medicalHistory->weight }} kg<br>
            <strong>Altura:</strong> {{ $medicalHistory->height }} cm<br>
            <strong>Diagnóstico y Tratamiento:</strong>
            @if(!empty($medicalHistory->diagnosis_treatment))
                {{ strip_tags(html_entity_decode($medicalHistory->diagnosis_treatment)) }}<br>
            @else
                N/A
            @endif
            <strong>Comentarios:</strong>
            @if(!empty($medicalHistory->comments))
                {{ strip_tags(html_entity_decode($medicalHistory->comments)) }}<br>
            @else
                N/A
            @endif
        </div>
    </div>
</body>
</html>
