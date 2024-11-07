<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\Patient;
use App\Exports\PacientesExport;
use App\Exports\HistorialClinicoExport;
use App\Exports\ProductosFarmaciaExport; 
use App\Exports\SalidasMedicamentosExport; 
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function reportePacientes()
    {
        return Excel::download(new PacientesExport(), 'reporte_pacientes.xlsx');
    }

    public function reporteHistoriales()
    {
        return Excel::download(new HistorialClinicoExport(), 'reporte_historiales.xlsx'); 
    }

    public function reporteFarmacia()
    {
        return Excel::download(new ProductosFarmaciaExport(), 'reporte_farmacia.xlsx'); 
    }


}