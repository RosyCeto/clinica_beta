@extends('layouts.layout')

@section('title', 'Generar Reportes')

@section('header', 'Generar Reportes')

@section('content')
    <style>
        body {
            background-color: #f8f9fa; 
            font-family: 'Arial', sans-serif; 
            color: #333; 
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); 
        }

        .list-group {
            display: flex;
            flex-direction: column;
            align-items: center; 
            max-width: 600px; 
            margin: 0 auto; 
            padding: 0; 
        }

        .list-group-item {
            background-color: #ffffff; 
            border: 1px solid #dee2e6; 
            border-radius: 8px; 
            margin: 10px 0; 
            padding: 15px; 
            width: 100%; 
            transition: all 0.3s ease; 
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }

        .list-group-item:hover {
            background-color: #e9ecef; 
            transform: translateY(-2px); 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
        }

        .list-group-item-action {
            color: #007bff; 
            text-decoration: none; 
            font-size: 1.2em;
            text-align: center;
        }
    </style>

    <h2>Generar Reportes</h2>
    <p class="text-center">Selecciona el tipo de reporte que deseas generar:</p>

    <div class="list-group">
        <a href="{{ route('reportes.pacientes') }}" class="list-group-item list-group-item-action">Reporte de Pacientes</a>
        <a href="{{ route('reportes.historiales') }}" class="list-group-item list-group-item-action">Reporte de Historial Clínico</a>
        <a href="{{ route('reportes.farmacia') }}" class="list-group-item list-group-item-action">Reporte de Datos de Farmacia</a>
    </div>
@endsection