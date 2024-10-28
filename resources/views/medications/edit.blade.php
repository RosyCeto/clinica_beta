@extends('layouts.layout')

@section('title', 'Editar Medicamento')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif; /* Applying the new font */
        background-color: #f8f9fa; /* Light background for contrast */
    }

    .container {
        margin-top: 120px; /* Increased top margin for more space */
        margin-bottom: 50px; /* Optional bottom margin for spacing */
    }

    .card {
        border-radius: 10px;
        border: none; /* Remove default card border */
    }

    .card-header {
        background-color: #3498db; /* Card header color */
        color: white; /* Text color in header */
        border-top-left-radius: 10px; /* Rounded corners */
        border-top-right-radius: 10px; /* Rounded corners */
    }

    .btn-primary {
        background-color: #3498db; /* Button color */
        border: none; /* Remove default border */
    }

    .btn-primary:hover {
        background-color: #2980b9; /* Darker shade on hover */
    }

    .form-group label {
        font-weight: 500; /* Slightly bold labels */
    }

    h1 {
        color: #2c3e50; /* Header color */
        font-weight: 600; /* Bold header */
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
                    <form action="{{ route('medications.update', $medication->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $medication->nombre }}" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ $medication->descripcion }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" value="{{ $medication->cantidad }}" required min="1">
                        </div>
                        <div class="form-group">
                            <label for="fecha_caducidad">Fecha de Caducidad</label>
                            <input type="date" name="fecha_caducidad" class="form-control" value="{{ $medication->fecha_caducidad->format('Y-m-d') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
