@extends('layouts.layout')

@section('title', 'Reprogramar Cita')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm border-0" style="max-width: 400px; width: 100%;"> <!-- Añadido max-width -->
        <h1 class="text-center mb-3 text-primary">Reprogramar Cita</h1>

        @if(session('success'))
            <div class="alert alert-success text-center py-2">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-body p-3">
            <form action="{{ route('citas.update', $cita->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="paciente" class="text-secondary">Paciente:</label>
                    <input type="text" class="form-control-plaintext px-2" id="paciente" value="{{ $cita->paciente->primer_nombre . ' ' . $cita->paciente->primer_apellido }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="medico" class="text-secondary">Médico:</label>
                    <input type="text" class="form-control-plaintext px-2" id="medico" value="{{ $cita->medico->nombre }}" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="fecha" class="text-secondary">Nueva Fecha:</label>
                    <input type="datetime-local" class="form-control form-control-sm border-primary" id="fecha" name="fecha" value="{{ \Carbon\Carbon::parse($cita->fecha)->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="text-secondary">Estado:</label>
                    <select class="form-control form-control-sm border-primary" id="status" name="status" required>
                        <option value="pendiente" {{ $cita->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="cancelada" {{ $cita->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-sm mr-2">
                        <i class="fas fa-save"></i>
                    </button>
                    <a href="{{ route('citas.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .form-control-plaintext {
        background-color: #f8f9fa;
        border: 1px solid #e0e0e0;
        padding: 4px 8px;
    }
    .form-group label {
        font-size: 0.9rem;
    }
    .btn-sm i {
        margin-right: 4px;
    }
    .btn-success, .btn-secondary {
        padding: 4px 10px;
    }
</style>
@endsection

