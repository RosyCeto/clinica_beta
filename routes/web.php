<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    AdminController,
    DoctorController,
    NurseController,
    LabTechController,
    PatientController,
    MedicalHistoryController,
    LaboratoryController,
    Auth\LoginController,
    ImageUploadController,
    UserController,
    ExamenController,
    MedicoController,
    RealizarExamenController,
    MedicationController,
    TipoAnalisisController,
    ResultadosLaboratorioController,
    InmunizacionController,
    VacunaController,
    DosisController,
    CitaController,
};

// Rutas básicas
Route::get('/', fn() => view('welcome'));

// Autenticación
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas que requieren autenticación
Route::group(['middleware' => ['auth']], function () {
    // Rutas para admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Rutas para doctor
    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');

    // Rutas para enfermera
    Route::get('/nurse/dashboard', [NurseController::class, 'index'])->name('nurse.dashboard');

    // Rutas de recursos para pacientes
    Route::resource('patients', PatientController::class);
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

    // Rutas de recursos para historias médicas
    Route::resource('medical_histories', MedicalHistoryController::class);
    Route::get('/medical_histories/create/{patient_id}', [MedicalHistoryController::class, 'create'])->name('medical_histories.create');
    Route::post('/medical_histories', [MedicalHistoryController::class, 'store'])->name('medical_histories.store');
    Route::get('/medical_histories/{id}/pdf', [MedicalHistoryController::class, 'showPdf'])->name('medical_histories.show_pdf');

    // Rutas de imagen
    Route::post('/upload/image', [ImageUploadController::class, 'uploadImage'])->name('image.upload');

    // Rutas para usuarios
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{id}/toggleStatus', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Rutas para laboratorio
    Route::get('/laboratory', [LaboratoryController::class, 'index'])->name('laboratory.index');

    // Rutas para medicamentos
    Route::resource('medications', MedicationController::class);
    Route::post('medications/{medication}/entry', [MedicationController::class, 'recordEntry'])->name('medications.recordEntry');
    Route::post('medications/{medication}/exit', [MedicationController::class, 'recordExit'])->name('medications.recordExit');

    // Rutas para exámenes
    Route::resource('examenes', ExamenController::class);
    Route::get('/search/examenes', [ExamenController::class, 'searchByTipoAnalisis']);
    Route::post('/realizar_examenes', [RealizarExamenController::class, 'store'])->name('realizar_examenes.store');

    // Rutas para resultados de laboratorio
    Route::resource('resultados', ResultadosLaboratorioController::class);
    Route::post('/resultados/{id}/subir-archivo', [ResultadosLaboratorioController::class, 'subirArchivo'])->name('resultados.subirArchivo');

    // Rutas para inmunizaciones
    Route::resource('inmunizaciones', InmunizacionController::class);
    Route::resource('vacunas', VacunaController::class);
    Route::resource('dosis', DosisController::class);

    // Rutas para citas
    Route::resource('citas', CitaController::class);
    Route::post('/citas/{id}/cancelar', [CitaController::class, 'cancel'])->name('citas.cancel');
    Route::get('/citas/{id}/edit', [CitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
});

// Rutas de búsqueda para médicos
Route::get('/search/medicos', [MedicoController::class, 'search'])->name('medicos.search');
Route::resource('medicos', MedicoController::class);

Route::resource('realizar_examenes', RealizarExamenController::class);
Route::resource('tipos-analisis', TipoAnalisisController::class);
Route::get('/tipos-analisis', [TipoAnalisisController::class, 'index'])->name('tipos-analisis.index');
Route::delete('/tipos-analisis/{id}', [TipoAnalisisController::class, 'destroy'])->name('tipos-analisis.destroy');


Route::get('/lab-tech-dashboard', [LaboratoryController::class, 'index'])->name('lab.tech.dashboard');
Route::get('/inmunizaciones', [InmunizacionController::class, 'index'])->name('inmunizaciones.index');
Route::get('/nurses', [NurseController::class, 'index'])->name('nurses.index');
Route::resource('doctors', DoctorController::class);
Route::get('/inmunizaciones/mostrarDosis', [InmunizacionController::class, 'mostrarDosis'])->name('inmunizaciones.mostrarDosis');
Route::get('/resultados/create/{realizarExamenId}', [ResultadosLaboratorioController::class, 'create'])->name('resultados.create');
Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil')->middleware('auth');
Route::get('users/{id}/editImage', [UserController::class, 'editImage'])->name('users.editImage');
Route::patch('users/{id}/updateImage', [UserController::class, 'updateImage'])->name('users.updateImage');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

use App\Http\Controllers\ReporteController;

// Rutas de reportes
Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('/reportes/pacientes', [ReporteController::class, 'reportePacientes'])->name('reportes.pacientes');
Route::get('/reportes/historiales', [ReporteController::class, 'reporteHistoriales'])->name('reportes.historiales');
Route::get('/reportes/farmacia', [ReporteController::class, 'reporteFarmacia'])->name('reportes.farmacia');

Route::get('/reportes/historiales', [ReporteController::class, 'reporteHistoriales'])->name('reportes.historiales');
Route::get('/reportes/farmacia', [ReporteController::class, 'reporteFarmacia'])->name('reportes.farmacia');
Route::post('/inmunizaciones/dosis', [InmunizacionController::class, 'mostrarDosis'])->name('inmunizaciones.mostrarDosis');

// Ruta para registrar la salida
Route::post('medications/sale', [MedicationController::class, 'sale'])->name('medications.sale');
use App\Http\Controllers\SalidaController;

Route::resource('salidas', SalidaController::class);
Route::get('/export/salidas', [ReporteController::class, 'exportSalidas'])->name('export.salidas');

Route::get('/eliminar-citas-pasadas', [CitaController::class, 'eliminarPasadas']);
