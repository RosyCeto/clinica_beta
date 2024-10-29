@extends('layouts.layout')

@section('title', 'Editar Imagen de Usuario')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Editar Imagen de Usuario</h2>
    
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <!-- Mostrar la imagen actual del usuario -->
            <img src="{{ asset('storage/' . $user->foto) }}" alt="Imagen actual" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <p class="text-muted">Imagen actual</p>

            <form action="{{ route('users.updateImage', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Campo para subir nueva imagen -->
                <div class="form-group">
                    <label for="foto">Subir Nueva Imagen</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Actualizar Imagen</button>
                <a href="{{ route('perfil') }}" class="btn btn-secondary mt-3">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
