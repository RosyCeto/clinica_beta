@extends('layouts.layout')

@section('title', 'Dashboard')

@section('header', 'Bienvenido, Doctor(a)')

@section('content')
    <style>
        /* Estilo para el contenedor de bienvenida */
        .welcome-container {
            text-align: center;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 20px auto;
            max-width: 800px;
        }

        /* Título de bienvenida */
        .welcome-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        /* Imagen de bienvenida */
        .welcome-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
        }

        /* Efecto hover para la imagen */
        .welcome-image img:hover {
            transform: scale(1.03);
            transition: transform 0.3s ease;
        }
    </style>

    <div class="welcome-container">
        <h2 class="welcome-title">Aquí puedes ingresar pacientes, historias clínicas, ver resultados de exámenes, agendar citas y ver inmunizaciones.</h2>
        <div class="welcome-image">
            <img src="{{ asset('plantilla/dist/img/medico.avif') }}" alt="Imagen de Bienvenida">
        </div>
    </div>
@endsection
