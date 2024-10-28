@extends('layouts.layout')

@section('title', 'Historial Clínico')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial Clínico</h1>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario de búsqueda -->
    <form id="searchForm" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Buscar paciente por nombre, ID o número de expediente" value="{{ request()->query('search') }}">
            <button class="btn btn-outline-secondary" type="button" id="searchButton" aria-label="Buscar paciente">Buscar</button>
            <a href="{{ route('medical_histories.index') }}" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
        </div>
    </form>

    <h2>Resultados de Búsqueda</h2>

    <!-- Contenedor de resultados de búsqueda -->
    <div id="searchResults">
        @include('medical_histories.partials.search_results', ['patients' => $patients])

        <!-- Enlaces de paginación -->
        <div class="mt-4">
            {{ $patients->appends(request()->query())->links() }} <!-- Agrega esto para mostrar la paginación -->
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function searchPatients() {
        $.ajax({
            url: "{{ route('medical_histories.index') }}",
            type: "GET",
            data: $('#searchForm').serialize(),
            success: function(data) {
                $('#searchResults').html(data);
            }
        });
    }

    $('#searchInput').on('keyup', function() {
        searchPatients();
    });

    $('#searchButton').on('click', function() {
        searchPatients();
    });
});
</script>
@endsection
