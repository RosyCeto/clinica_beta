@extends('layouts.layout')

@section('title', 'Editar Medicamento')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif; 
        background-color: #f8f9fa; 
    }

    .container {
        margin-top: 120px; 
        margin-bottom: 50px; 
    }

    .card {
        border-radius: 10px;
        border: none; 
    }

    .card-header {
        background-color: #3498db; 
        color: white; 
        border-top-left-radius: 10px; 
        border-top-right-radius: 10px; 
    }

    .btn-primary {
        background-color: #3498db; 
        border: none; 
    }

    .btn-primary:hover {
        background-color: #2980b9; 
    }

    .form-group label {
        font-weight: 500; 
    }

    h1 {
        color: #2c3e50; 
        font-weight: 600; 
    }

    .alert {
        margin-bottom: 20px;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-4">Editar Medicamento</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Detalles del Medicamento</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('medications.update', $medication->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $medication->codigo) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $medication->nombre) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $medication->descripcion) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', $medication->cantidad) }}" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="fecha_caducidad">Fecha de Caducidad</label>
                            <input type="date" name="fecha_caducidad" class="form-control" value="{{ old('fecha_caducidad', $medication->fecha_caducidad->format('Y-m-d')) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection