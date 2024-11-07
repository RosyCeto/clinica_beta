@extends('layouts.layout')

@section('title', 'Inmunizaciones Registradas')

@section('content')
<div class="container">
    <h1>Inmunizaciones Registradas</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('inmunizaciones.create') }}" class="btn btn-success btn-sm mb-3">Registrar Nueva Inmunización</a>

    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Buscar por ID, Paciente o Vacuna">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Vacuna</th>
                <th>Dosis</th>
                <th>Fecha de Vacunación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="inmunization-table-body">
            @foreach ($inmunizaciones as $inmunizacion)
                <tr>
                    <td>{{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->primer_apellido }}</td>
                    <td>{{ $inmunizacion->vacuna->nombre }}</td>
                    <td>{{ $inmunizacion->dosis->nombre }}</td>
                    <td>{{ $inmunizacion->fecha_vacunacion->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('inmunizaciones.edit', $inmunizacion->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="delete-form-{{ $inmunizacion->id }}" action="{{ route('inmunizaciones.destroy', $inmunizacion->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(event, {{ $inmunizacion->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        {{ $inmunizaciones->links() }} <!-- Paginación -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
    function confirmDelete(event, examenId) {
        event.preventDefault(); 
        Swal.fire({
            title: '¿Está seguro que quiere eliminar esta inmunización?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + examenId).submit(); 
            }
        });
    }

    $(document).ready(function() {
        $('#search').on('keyup', function() {
            let searchValue = $(this).val().toLowerCase();
            $('#inmunization-table-body tr').filter(function() {
                $(this).toggle(
                    $(this).children('td').eq(0).text().toLowerCase().indexOf(searchValue) > -1 || 
                    $(this).children('td').eq(1).text().toLowerCase().indexOf(searchValue) > -1 || 
                    $(this).children('td').eq(2).text().toLowerCase().indexOf(searchValue) > -1 
                );
            });
        });
    });
</script>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-control {
        width: 100%;
        border-radius: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .btn {
        font-size: 1.2rem;
        padding: 5px 10px;
    }
</style>

@endsection