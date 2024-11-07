@extends('layouts.layout')

@section('title', 'Editar Médico')

@section('content')
<div class="container">
    <h1>Editar Médico</h1>
    <form action="{{ route('medicos.update', $medico->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $medico->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="cui">CUI</label>
            <input type="text" name="cui" class="form-control" value="{{ $medico->cui }}" maxlength="13">
        </div>
        <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="{{ $medico->especialidad }}" required>
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ $medico->telefono }}" maxlength="8" required>
        </div>
        <div class="form-group">
            <label for="correo">Correo Electrónico</label>
            <input type="email" name="correo" class="form-control" value="{{ $medico->correo }}" required>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar</button>
    </form>
</div>
@endsection