@extends('layouts.layout')

@section('title', 'Generar Reportes')

@section('header', 'Generar Reportes')

@section('content')
    <style>
        body {
            background-color: #f8f9fa; /* Fondo suave */
            font-family: 'Arial', sans-serif; /* Fuente moderna */
            color: #333; /* Color del texto */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Sombra en el texto */
        }

        .list-group {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centra los elementos */
            max-width: 600px; /* Ancho máximo para la lista */
            margin: 0 auto; /* Centrar la lista en la página */
            padding: 0; /* Sin padding */
        }

        .list-group-item {
            background-color: #ffffff; /* Fondo blanco para los elementos */
            border: 1px solid #dee2e6; /* Borde suave */
            border-radius: 8px; /* Bordes redondeados */
            margin: 10px 0; /* Espaciado entre los elementos */
            padding: 15px; /* Padding interno */
            width: 100%; /* Ocupa el ancho total */
            transition: all 0.3s ease; /* Transición suave para efectos */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra para profundidad */
        }

        .list-group-item:hover {
            background-color: #e9ecef; /* Cambio de color al pasar el mouse */
            transform: translateY(-2px); /* Elevación al pasar el mouse */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Aumenta la sombra al pasar el mouse */
        }

        .list-group-item-action {
            color: #007bff; /* Color del texto de los enlaces */
            text-decoration: none; /* Sin subrayado */
            font-size: 1.2em; /* Tamaño de fuente aumentado */
            text-align: center; /* Centrar el texto */
        }
    </style>

    <h2>Generar Reportes</h2>
    <p class="text-center">Selecciona el tipo de reporte que deseas generar:</p>

    <div class="list-group">
        <a href="{{ route('reportes.pacientes') }}" class="list-group-item list-group-item-action">Reporte de Pacientes</a>
        <a href="{{ route('reportes.historiales') }}" class="list-group-item list-group-item-action">Reporte de Historial Clínico</a>
        <a href="{{ route('reportes.farmacia') }}" class="list-group-item list-group-item-action">Reporte de Datos de Farmacia</a>
        <a href="{{ route('export.salidas') }}" class="btn btn-warning">Exportar Salidas</a>
    </div>
@endsection
