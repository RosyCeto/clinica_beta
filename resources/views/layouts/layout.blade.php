<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HICAX CENTRO DE SALUD')</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plantilla/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plantilla/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('plantilla/dist/css/adminlte.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css') <!-- Sección para incluir CSS adicionales -->
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- Botón PushMenu -->
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.index') }}" class="nav-link">Inicio</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                
                <!-- Notifications Dropdown Menu -->
<li class="nav-item dropdown">
    <a class="nav-link position-relative" id="notificationDropdown" data-toggle="dropdown" href="#">
        <i class="fas fa-bell fa-lg"></i> <!-- Ícono de notificación de tamaño normal -->
        <span class="badge badge-warning position-absolute" style="top: 0; right: 10px;">{{ $citasPendientesCount }}</span>
        <span class="badge badge-info position-absolute" style="top: 0; right: -5px;">{{ $examenesPendientesCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header" style="font-size: 0.9rem;">Tienes {{ $citasPendientesCount }} citas próximas o pendientes</span>
        <span class="dropdown-item dropdown-header" style="font-size: 0.9rem;">Tienes {{ $examenesPendientesCount }} exámenes pendientes</span>
        <div class="dropdown-divider"></div>
        <a href="{{ route('citas.index') }}" class="dropdown-item" style="font-size: 0.9rem;">
            <i class="fas fa-calendar-alt mr-2"></i> Ver Citas
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('realizar_examenes.index') }}" class="dropdown-item" style="font-size: 0.9rem;">
            <i class="fas fa-file-medical mr-2"></i> Ver Exámenes
        </a>
        <div class="dropdown-divider"></div>
        <a href="{{ route('citas.index') }}" class="dropdown-item dropdown-footer" style="font-size: 0.9rem;">Ver todas las citas</a>
    </div>
</li>




                
                <!-- User Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        @if (Auth::check() && Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="User Image" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">
                        @else
                            <i class="fas fa-user-circle"></i>
                        @endif
                        {{ Auth::check() ? Auth::user()->name : 'Invitado' }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        @if (Auth::check())
                            <a href="{{ route('perfil') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Perfil
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="dropdown-item">
                                <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
                            </a>
                        @endif
                    </div>
                </li>
                
                

            </ul>
        </nav>
        <!-- Resto de tu layout -->

        <!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="overflow-y: auto;">
    <!-- Logo de la Institución -->
    <div class="brand-link text-center p-3" style="background-color: #3c8dbc; display: flex; flex-direction: column; align-items: center;">
        <img src="{{ asset('plantilla/dist/img/salud.jpg') }}" alt="Institución Logo" class="brand-image elevation-3" style="max-width: 150px; height: 150px; border-radius: 50%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <span class="brand-text font-weight-bold text-white" style="margin-top: 10px; font-size: 1.5em;">Bienvenido</span>
    </div>

    <!-- Menú de Navegación -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Sección Principal -->
            <li class="nav-header mt-2">PRINCIPAL</li>

            <!-- Ítem de Inicio -->
            <li class="nav-item">
                @if(auth()->user()->hasRole('nurse'))
                    <a href="{{ route('nurses.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home text-primary"></i>
                        <p class="ml-2">Inicio</p>
                    </a>
                @elseif(auth()->user()->hasRole('doctor'))
                    <a href="{{ route('doctors.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home text-primary"></i>
                        <p class="ml-2">Inicio</p>
                    </a>
                @elseif(auth()->user()->hasRole('lab_tech'))
                    <a href="{{ route('laboratory.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home text-primary"></i>
                        <p class="ml-2">Inicio</p>
                    </a>
                @else
                    <a href="{{ route('admin.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-home text-primary"></i>
                        <p class="ml-2">Inicio</p>
                    </a>
                @endif
            </li>

            <!-- Pacientes -->
            <li class="nav-item">
                <a href="{{ route('patients.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-user text-success"></i>
                    <p class="ml-2">Pacientes</p>
                </a>
            </li>

            <!-- Roles específicos -->
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('doctor'))
                <li class="nav-header mt-4">HISTORIAS CLÍNICAS</li>
                <li class="nav-item">
                    <a href="{{ route('medical_histories.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-medical text-warning"></i>
                        <p class="ml-2">Historias Clínicas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('resultados.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-flask text-purple"></i>
                        <p class="ml-2">Resultados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inmunizaciones.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-orange"></i>
                        <p class="ml-2">Inmunizaciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('citas.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt text-cyan"></i>
                        <p class="ml-2">Citas</p>
                    </a>
                </li>
            @endif

            @if(Auth::user()->hasRole('admin'))
                <!-- Sección de Configuración -->
                <li class="nav-header mt-4">CONFIGURACIONES</li>

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users text-light"></i>
                        <p class="ml-2">Usuarios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('medicos.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-md text-light"></i>
                        <p class="ml-2">Médicos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('medications.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-pills text-danger"></i>
                        <p class="ml-2">Farmacia</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('realizar_examenes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-notes-medical text-info"></i>
                        <p class="ml-2">Realizar Exámenes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('tipos-analisis.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt text-light"></i>
                        <p class="ml-2">Tipos de Análisis</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('examenes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt text-gray"></i>
                        <p class="ml-2">Exámenes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('vacunas.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-teal"></i>
                        <p class="ml-2">Vacunas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dosis.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-lime"></i>
                        <p class="ml-2">Dosis</p>
                    </a>
                </li>
            @elseif(Auth::user()->hasRole('nurse'))
                <!-- Sección de Enfermero -->
                <li class="nav-item">
                    <a href="{{ route('inmunizaciones.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-orange"></i>
                        <p class="ml-2">Inmunizaciones</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('vacunas.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-teal"></i>
                        <p class="ml-2">Vacunas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dosis.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-syringe text-lime"></i>
                        <p class="ml-2">Dosis</p>
                    </a>
                </li>
            @elseif(Auth::user()->hasRole('lab_tech'))
                <!-- Sección de Técnico de Laboratorio -->
                <li class="nav-header mt-4">LABORATORIO</li>

                <li class="nav-item">
                    <a href="{{ route('realizar_examenes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-notes-medical text-info"></i>
                        <p class="ml-2">Realizar Exámenes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('resultados.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-flask text-purple"></i>
                        <p class="ml-2">Resultados</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('tipos-analisis.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt text-light"></i>
                        <p class="ml-2">Tipos de Análisis</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('examenes.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-file-alt text-gray"></i>
                        <p class="ml-2">Exámenes</p>
                    </a>
                </li>
            @endif

            <!-- Cerrar Sesión -->
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                    <p class="ml-2">Cerrar Sesión</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>

            <!-- Ayuda -->
<li class="nav-item">
    <a href="https://drive.google.com/file/d/12LvgCxA9JhTIboIjHqeqs7EPJ9N3jc9u/view?usp=sharing" class="nav-link" target="_blank">
        <i class="nav-icon fas fa-question-circle text-info"></i>
        <p class="ml-2">Ayuda</p>
    </a>
</li>


<li class="nav-item">
    <a href="https://drive.google.com/file/d/1lXQcGXTMiWgGJGcff2pI8d_LNazaA-2V/view?usp=sharing" class="nav-link" target="_blank">
        <i class="nav-icon fas fa-tools text-info"></i>
        <p class="ml-2">Soporte Técnico</p>
    </a>
</li> 
        </ul>
    </nav>
</aside>





        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header')</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
<footer class="main-footer" style="padding: 5px 10px; font-size: 12px;">
    <div class="d-flex align-items-center">
        <div class="mr-2">
            <img src="{{ asset('plantilla/dist/img/UMG.png') }}" alt="Logo UMG" style="max-height: 30px;">
        </div>
        <div>
            <strong>Proyecto de Graduación 2024</strong> | 
            <span>Universidad Mariano Gálvez</span>
        </div>
    </div>
</footer>




        

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plantilla/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plantilla/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('plantilla/dist/js/adminlte.js') }}"></script>
    @yield('js') <!-- Scripts adicionales -->
    @yield('js') <!-- Sección para incluir JS adicionales -->


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>