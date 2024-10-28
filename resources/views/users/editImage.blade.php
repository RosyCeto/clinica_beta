@extends('layouts.layout')

@section('title', 'Editar Imagen de Usuario')

@section('content')
<div class="container">
    <h1>Editar Imagen</h1>
    <form action="{{ route('users.updateImage', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <!-- Campo para subir nueva imagen -->
        <button type="submit" class="btn btn-primary">Actualizar Imagen</button>
    </form>
</div>
@endsection
