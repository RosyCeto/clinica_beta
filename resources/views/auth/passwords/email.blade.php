@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg" style="border-radius: 20px; background-color: #ffffff;">
            <div class="card-header text-center" style="background-color: #ffffff; border-radius: 20px 20px 0 0; padding: 30px;">
                <img src="{{ asset('plantilla/dist/img/Logotipo-MSPAS.png') }}" alt="Logo" width="150" class="mb-3">
                <h4 class="text-primary mb-0" style="font-weight: 600;">{{ __('Restablecer Contraseña') }}</h4>
            </div>

            <div class="card-body px-5 py-4">
                @if (session('status'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="email" class="form-label" style="font-weight: 500; color: #495057;">{{ __('Correo Electrónico') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Ingresa tu correo electrónico" style="padding: 1rem; border-radius: 10px; border: 1px solid #ced4da;">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-block" style="width: 100%; padding: 0.75rem; font-size: 1rem; border-radius: 10px; background-color: #007bff; border: none; color: white; font-weight: 600; transition: background 0.3s;">
                        {{ __('Enviar Enlace de Restablecimiento') }}
                    </button>
                </form>
            </div>

            <div class="card-footer text-center" style="background-color: #f1f3f5; border-radius: 0 0 20px 20px; padding: 20px;">
                <small class="text-muted">Recibirás un enlace en tu correo electrónico para restablecer tu contraseña</small>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #e9ecef;
        font-family: 'Roboto', sans-serif;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .form-control {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }
    .form-control:focus {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        border-color: #80bdff;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>
@endsection
