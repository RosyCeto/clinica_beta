@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color: #ffffff;">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-lg p-4" style="border-radius: 15px; background-color: #ffffff;">
            <div class="card-header text-center bg-transparent">
                <img src="{{ asset('plantilla/dist/img/Logotipo-MSPAS.png') }}" alt="Imagen de Login" width="150" class="mb-3">
                <h4 class="fw-bold text-primary mb-1">{{ __('Restablecer Contraseña') }}</h4>
                <p class="text-muted" style="font-size: 0.9rem;">Ingresa tu correo y una nueva contraseña para recuperar el acceso</p>
            </div>
            
            <div class="card-body px-4">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" placeholder="Ejemplo@correo.com" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autofocus style="border-radius: 8px;">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <small><strong>{{ $message }}</strong></small>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">{{ __('Nueva Contraseña') }}</label>
                        <input id="password" type="password" placeholder="********" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required style="border-radius: 8px;">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <small><strong>{{ $message }}</strong></small>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                        <input id="password-confirm" type="password" placeholder="********" class="form-control form-control-lg" name="password_confirmation" required style="border-radius: 8px;">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" style="border-radius: 8px;">
                            {{ __('Restablecer Contraseña') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #ffffff;
        font-family: 'Arial', sans-serif;
    }
    .card {
        border: none;
    }
    .form-control:focus {
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        border-color: #007bff;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection