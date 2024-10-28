@extends('layouts.layout')

@section('title', 'Editar Resultados')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-3" style="font-family: 'Arial', sans-serif; font-weight: bold; color: #007bff;">Editar Resultado</h1>

    <div class="card shadow-sm" style="max-width: 400px; margin: auto; background-color: white; border: none;">
        <div class="card-body p-3">
            <form action="{{ route('resultados.update', $resultado->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="realizar_examen_id" class="text-primary">Examen</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $resultado->realizarExamen->id }}" disabled>
                </div>

                <div class="form-group mb-2">
                    <label for="archivo" class="text-primary">Archivo</label>
                    @if ($resultado->archivo)
                        <div class="mb-1">
                            <a href="{{ Storage::url($resultado->archivo) }}" target="_blank" class="btn btn-link btn-sm text-success">
                                <i class="fas fa-file-download"></i> Ver Archivo
                            </a>
                        </div>
                    @endif
                    <input type="file" class="form-control form-control-sm" name="archivo" id="archivo" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">Opcional: Selecciona uno nuevo.</small>
                </div>

                <div class="form-group mb-2">
                    <label for="comentarios" class="text-primary">Comentarios</label>
                    <textarea class="form-control form-control-sm" name="comentarios" id="comentarios" rows="2">{{ $resultado->comentarios }}</textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save"></i>
                    </button>
                    <a href="{{ route('resultados.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection