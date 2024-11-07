<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Médico del Paciente</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            border: 2px solid #2980b9; 
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 24px;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }
        .content p {
            margin: 10px 0;
        }
        .content strong {
            color: #2980b9;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('plantilla/dist/img/salud.jpg') }}" alt="Logotipo MSPAS">
            <h1>Historial Médico del Paciente</h1>
            <div><strong>No. Expediente:</strong> {{ $patient->nexpedientes }}</div>
        </div>

        <!-- Datos Generales del Paciente -->
        <div class="content">
            <p><strong>CUI:</strong> {{ $patient->cui }}</p>
            <p><strong>Nombre Completo:</strong> {{ $patient->full_name }}</p>
            <p><strong>Apellido de Casada:</strong> {{ $patient->apellido_casada }}</p>
            <p><strong>Sexo:</strong> {{ $patient->gender }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $patient->fecha_nacimiento }}</p>
            <p><strong>Edad:</strong> {{ $patient->edad }} años</p>
            <p><strong>Discapacidad:</strong> {{ $patient->discapacidad ?? 'N/A' }}</p>
        </div>

        <!-- Tipo de Consulta -->
        <div class="content">
            <p><strong>Tipo de Consulta:</strong> {{ $medicalHistory->type_consult ?? 'N/A' }}</p>
        </div>

        <!-- Motivo de Consulta -->
        <div class="content">
            <p><strong>Motivo de Consulta:</strong> @if(!empty(trim($medicalHistory->consultation_reason))){{ strip_tags(html_entity_decode($medicalHistory->consultation_reason)) }}@else N/A @endif</p>
        </div>
    
        <!-- Historia de la Enfermedad Actual -->
        <div class="content">
            <p><strong>Historia de la Enfermedad Actual:</strong> @if(!empty(trim($medicalHistory->current_illness_history))){{ strip_tags(html_entity_decode($medicalHistory->current_illness_history)) }}@else N/A @endif</p>
        </div>
    
        <!-- Antecedentes de la Primera Consulta -->
        <div class="content">
            <p><strong>Historia Personal:</strong> {{ $firstConsultation->personal_history ?? 'N/A' }}</p>
            <p><strong>Historia Familiar:</strong> {{ $firstConsultation->family_history ?? 'N/A' }}</p>
            <p><strong>Historia de Hábitos:</strong> {{ $firstConsultation->habits_history ?? 'N/A' }}</p>
            <p><strong>Alergias:</strong> {{ $firstConsultation->allergies ?? 'N/A' }}</p>
        </div>
    
        <!-- Diagnóstico y Tratamiento -->
        <div class="content">
            <p><strong>Diagnóstico y Tratamiento:</strong> @if(!empty($medicalHistory->diagnosis_treatment)){{ strip_tags(html_entity_decode($medicalHistory->diagnosis_treatment)) }}@else N/A @endif</p>
        </div>
    
        <!-- Comentarios -->
        <div class="content">
            <p><strong>Comentarios:</strong> @if(!empty($medicalHistory->comments)){{ strip_tags(html_entity_decode($medicalHistory->comments)) }}@else N/A @endif</p>
        </div>

        <div class="footer">
            <p>&copy; Expediente Médico - Centro de Salud Cantón Xebac</p>
        </div>
    </div>
</body>
</html>