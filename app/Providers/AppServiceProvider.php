<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cita;
use App\Models\RealizarExamen;
use App\Models\Appointment; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('layouts.layout', function ($view) {
            
            $citasPendientesCount = Cita::where('status', 'pendiente')->count();
            $view->with('citasPendientesCount', $citasPendientesCount);

             
            $examenesPendientesCount = RealizarExamen::where('status', 'pendiente')->count();
            $view->with('examenesPendientesCount', $examenesPendientesCount);
        });

    }
}