@extends('layouts.app')

@section('content')
<style>
    .card-body {
        background-color: white; 
    }
    .form-label {
        color: black; 
    }
    .form-control {
        background-color: white; 
        color: black; 
    }
    .form-control:focus {
        background-color: white; 
        border-color: #007bff; 
    }
    .custom-container {
        max-width: 400px; 
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center custom-container">
            <!-- Imagen de Login fuera del contenedor de la tarjeta -->
            <img src="{{ asset('plantilla/dist/img/Logotipo-MSPAS.png') }}" alt="Imagen de Login" width="150">
            <div class="card mt-3 bg-white">
                <div class="card-header text-center">{{ __('Inicio de Sesión') }}</div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Ingrese Usuario') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Recuerdame') }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Acceder') }}
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    </div>
                    <div class="text-center mt-3">
                        <p>¿No tienes una cuenta? <a href="{{ route('register') }}">{{ __('Registrate') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection