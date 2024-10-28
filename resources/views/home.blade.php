@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h1>Bienvenido al Home</h1>
    <!-- Aquí puedes agregar más contenido -->
</div>
@endsection
