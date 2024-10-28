@extends('layouts.layout')

@section('title', 'Editar Examen Realizado')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary">Editar Examen Realizado</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('realizar_examenes.update', $realizarExamen->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PATCH')

        <!-- Selección de Tipo de Análisis -->
        <div class="form-group">
            <label for="tipo_analisis_id">Tipo de Análisis</label>
            <select name="tipo_analisis_id" id="tipo_analisis_id" class="form-control" required>
                <option value="">Seleccione un tipo de análisis</option>
                @foreach ($tipos_analisis as $tipo)
                    <option value="{{ $tipo->id }}" {{ $realizarExamen->tipo_analisis_id == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>
        

        <!-- Selección de Examen -->
        <div class="form-group">
            <label for="examen_id">Examen</label>
            <select name="examen_id" id="examen_id" class="form-control" required>
                <option value="">Seleccione un examen</option>
                @foreach ($examenes as $examen)
                    <option value="{{ $examen->id }}" {{ $realizarExamen->examen_id == $examen->id ? 'selected' : '' }}>{{ $examen->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="medico_id">Médico</label>
            <select name="medico_id" class="form-control" required>
                @foreach ($medicos as $medico)
                    <option value="{{ $medico->id }}" {{ $realizarExamen->medico_id == $medico->id ? 'selected' : '' }}>{{ $medico->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="paciente_id">Paciente</label>
            <select name="paciente_id" class="form-control" required>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $realizarExamen->paciente_id == $paciente->id ? 'selected' : '' }}>{{ $paciente->primer_nombre }} {{ $paciente->primer_apellido }}</option>
                @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $realizarExamen->fecha }}" required>
        </div>

        <div class="form-group">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">Seleccione un estado</option>
                <option value="pendiente" {{ $realizarExamen->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="finalizado" {{ $realizarExamen->status == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
                <!-- Add more options as needed -->
            </select>
        </div>
        
      
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary w-100 mr-2">Actualizar</button>
            <a href="{{ route('realizar_examenes.index') }}" class="btn btn-secondary w-100">Cancelar</a>
        </div>
    </form>
</div>

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

    h1 {
        color: #007bff;
    }
</style>
@endsection