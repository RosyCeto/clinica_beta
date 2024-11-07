@extends('layouts.layout')

@section('title', 'Perfil de Usuario')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Perfil de Usuario</h2>
    
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            <!-- Mostrar la imagen del usuario -->
            <img src="{{ asset('storage/' . $usuario->foto) }}" alt="Foto de perfil" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">

            <h5 class="card-title">{{ $usuario->name }}</h5>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $usuario->created_at->format('d/m/Y') }}</p>

            <!-- Enlace para cambiar la foto de perfil -->
            <a href="{{ route('users.editImage', $usuario->id) }}" class="btn btn-primary mt-3">Cambiar Foto de Perfil</a>
        </div>
    </div>
</div>
@endsection