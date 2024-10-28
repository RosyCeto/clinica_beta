@extends('layouts.layout')

@section('title', 'Editar Usuario')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <!-- Campo para editar el nombre -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <!-- Campo para editar el correo -->
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- Campo para editar el rol -->
        <div class="form-group">
            <label for="role">Rol</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="nurse" {{ $user->role == 'nurse' ? 'selected' : '' }}>Enfermero</option>
                <option value="lab_tech" {{ $user->role == 'lab_tech' ? 'selected' : '' }}>Técnico de Laboratorio</option>
            </select>
        </div>

        <!-- Campo para editar la imagen de perfil -->
        <div class="form-group">
            <label for="foto">Imagen de Perfil</label>
            <input type="file" name="foto" id="foto" class="form-control-file">
            @if($user->foto)
                <img src="{{ asset('storage/'.$user->foto) }}" alt="Foto de {{ $user->name }}" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
