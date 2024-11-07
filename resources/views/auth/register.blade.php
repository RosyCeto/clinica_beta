@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; 

    .custom-container {
        max-width: 400px; 
        margin-top: 20px; 
        text-align: center; 
        border-radius: 12px; 
        overflow: hidden; 
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
    }

    .logo-image {
        margin: 20px 0; 
        width: 150px; 
    }

    .card-body {
        background-color: white; 
        border: none;
        padding: 30px; 
    }

    .form-label {
        color: #333; 
        font-weight: bold; 
    }

    .form-control {
        background-color: #f1f1f1; 
        border: 1px solid #ccc;
        border-radius: 5px; 
        transition: border-color 0.3s; 
    }

    .form-control:focus {
        background-color: white; 
        border-color: #007bff; 
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
        outline: none; 
    }

    .btn-primary {
        background-color: #007bff; 
        border-color: #007bff; 
        border-radius: 5px; 
        width: 100%; 
    }

    .btn-primary:hover {
        background-color: #0056b3; 
        border-color: #0056b3; 
    }

    .invalid-feedback {
        display: block; 
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
                    <!-- Enlace a la página de inicio de sesión -->
                    <a href="{{ route('login') }}" class="login-link">
                        ¿Ya tienes cuenta? Inicia sesión aquí
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection