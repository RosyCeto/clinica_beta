@extends('layouts.layout')

@section('title', 'Detalles del Paciente')

@section('content')
    <div class="container">
        <h1>Detalles del Paciente</h1>

        <p><strong>CUI:</strong> {{ $patient->cui }}</p>
        <p><strong>Fecha de Nacimiento:</strong> {{ $patient->birth_date }}</p>
        <p><strong>Género:</strong> {{ $patient->gender }}</p>
        <p><strong>Dirección:</strong> {{ $patient->address }}</p>
        <p><strong>Teléfono:</strong> {{ $patient->phone }}</p>
        <p><strong>Grupo Étnico:</strong> {{ $patient->etnia }}</p>
        <p><strong>Contacto de Emergencia:</strong> {{ $patient->emergency_contact }}</p>

        <div class="btn-group">
            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-warning">Editar</a>

            <form id="deleteForm" action="{{ route('patients.destroy', $patient) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
            </form>

            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Volver a la lista</a>
        </div>
    </div>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: '¿Está seguro que quiere eliminar este paciente?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit(); 
                }
            });
        }
    </script>
@endsection