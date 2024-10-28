@extends('layouts.layout')

@section('title', 'Registrar Nuevo Resultado de Laboratorio')

@section('content')
<div class="container mt-5">
    <h2 class="text-center my-4" style="color: #0056b3;">Registrar Nuevo Resultado de Laboratorio</h2>
    <div class="card">
        <div class="card-header" style="background-color: #343a40; color: #ffffff;">
            <h4 class="mb-0">Formulario de Registro</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('resultados.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="realizar_examen_id" value="{{ $realizar_examen_id }}">
                <div class="form-group">
                    <label for="archivo">Archivo</label>
                    <input type="file" class="form-control @error('archivo') is-invalid @enderror" id="archivo" name="archivo" required>
                    @error('archivo')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="comentarios">Comentarios (Opcional)</label>
                    <textarea name="comentarios" id="comentarios" class="form-control">{{ old('comentarios') }}</textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success" title="Guardar Resultado">
                        <i class="fas fa-save"></i>
                    </button>
                    <a href="{{ route('resultados.index') }}" class="btn btn-secondary" title="Cancelar">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .container {
        max-width: 600px; /* Limitar el ancho de la tarjeta */
    }
    .card {
        border-radius: 8px; /* Bordes redondeados para la tarjeta */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave para un mejor efecto */
    }
    .form-group label {
        font-weight: bold; /* Etiquetas en negrita */
        color: #0056b3; /* Color de las etiquetas */
    }
</style>

@endsection