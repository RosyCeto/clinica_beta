@extends('layouts.layout')

@section('title', 'Laboratorio')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 style="font-size: 2.5rem;">Laboratorio</h1> <!-- Aumenta el tamaño del título -->
            <!-- Descripción debajo del título -->
            <div class="mt-4">
                <p class="lead" style="font-size: 1.25rem;">Bienvenido al laboratorio. Aquí podrás realizar diversos exámenes y pruebas diagnósticas.</p> <!-- Aumenta el tamaño de la descripción -->
            </div>
            <!-- Imagen grande en el centro, con altura reducida -->
            <img src="{{ asset('plantilla/dist/img/instr.png') }}" class="img-fluid" alt="Laboratorio" style="width: 100%; height: auto; max-height: 350px; object-fit: cover;">
        </div>
    </div>
</div>
@endsection
