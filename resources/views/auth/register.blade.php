@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* Color de fondo general */
    }

    .custom-container {
        max-width: 400px; /* Ancho máximo del contenedor */
        margin-top: 20px; /* Espacio superior */
        text-align: center; /* Centrar el texto dentro del contenedor */
        border-radius: 12px; /* Bordes redondeados */
        overflow: hidden; /* Para asegurar que los bordes redondeados se mantengan */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Sombra más pronunciada */
    }

    .logo-image {
        margin: 20px 0; /* Espacio entre el logo y el contenedor del formulario */
        width: 150px; /* Ajustar el ancho del logo */
    }

    .card-body {
        background-color: white; /* Fondo blanco para el contenido del formulario */
        border: none; /* Sin borde */
        padding: 30px; /* Espacio interno */
    }

    .form-label {
        color: #333; /* Color del texto de las etiquetas */
        font-weight: bold; /* Negrita para las etiquetas */
    }

    .form-control {
        background-color: #f1f1f1; /* Fondo claro para los inputs */
        border: 1px solid #ccc; /* Borde gris */
        border-radius: 5px; /* Bordes redondeados en los inputs */
        transition: border-color 0.3s; /* Transición suave para el color del borde */
    }

    .form-control:focus {
        background-color: white; /* Fondo blanco al enfocar en el input */
        border-color: #007bff; /* Color del borde al enfocar */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Sombra ligera al enfocar */
        outline: none; /* Sin contorno */
    }

    .btn-primary {
        background-color: #007bff; /* Color del botón */
        border-color: #007bff; /* Color del borde del botón */
        border-radius: 5px; /* Bordes redondeados en el botón */
        width: 100%; /* Botón ocupa todo el ancho */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Color del botón al pasar el ratón */
        border-color: #0056b3; /* Color del borde al pasar el ratón */
    }

    .invalid-feedback {
        display: block; /* Asegura que los mensajes de error sean visibles */
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 custom-container">
            <img src="{{ asset('plantilla/dist/img/Logotipo-MSPAS.png') }}" alt="Imagen de Login" class="logo-image">

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Ingrese Nombre') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Ingrese Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Ingrese Contraseña') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">{{ __('Confirme Contraseña') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">{{ __('Rol') }}</label>
                        <select name="role" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Enfermero</option>
                            <option value="lab_tech">Técnico de Laboratorio</option>
                        </select>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
