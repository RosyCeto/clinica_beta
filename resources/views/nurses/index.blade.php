@extends('layouts.layout')

@section('title', 'Dashboard')

@section('header')
    <h1 class="text-center" style="font-family: 'Arial', sans-serif; color: #007bff; font-weight: 700; font-size: 2.5rem; margin-bottom: 20px;">
        Bienvenido, Enfermero(a)
    </h1>
@endsection

@section('content')
    <div class="container mt-4" style="background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <div class="row justify-content-center mt-3">
            <!-- Tarjeta de Inmunizaciones más ancha y corta -->
            <div class="col-md-3 mb-4">  
                <div class="card shadow h-100" style="border-radius: 10px; border: 1px solid #007bff;">
                    <img src="{{ asset('plantilla/dist/img/vacunas.jpg') }}" class="card-img-top" alt="Inmunizaciones" style="height: 60px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                    <div class="card-body d-flex flex-column" style="background-color: #f8f9fa;">
                        <h5 class="card-title text-center" style="color: #007bff; font-weight: 600; font-size: 1.5rem;">Inmunizaciones</h5>
                        <a href="{{ route('inmunizaciones.index') }}" class="btn btn-primary mt-auto" style="border-radius: 20px; font-weight: 600; padding: 10px 20px; transition: background-color 0.3s;">Ver Detalles</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagen grande en el centro -->
        <div class="text-center">
            <img src="{{ asset('plantilla/dist/img/vacunacion.jpg') }}" class="img-fluid" alt="Imagen Principal" style="width: 100%; max-height: 700px; object-fit: cover; border-radius: 10px;">
        </div>
    </div>
@endsection