<?php

namespace App\Http\Controllers;

use App\Models\RealizarExamen;
use App\Models\Medico;
use App\Models\Examen;
use App\Models\TipoAnalisis;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RealizarExamenController extends Controller
{

    public function index(Request $request)
{
    // Obtener el término de búsqueda desde la solicitud
    $search = $request->input('search');

    // Cargar los exámenes junto con sus relaciones y filtrar según la búsqueda
    $realizarExamenes = RealizarExamen::with(['examen.tipoAnalisis', 'medico', 'paciente', 'usuario'])
        ->when($search, function ($query) use ($search) {
            // Filtrar por ID, Usuario, Paciente, Médico y Fecha
            $query->where('id', 'like', "%{$search}%")
                  ->orWhereHas('usuario', function ($query) use ($search) {
                      $query->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('paciente', function ($query) use ($search) {
                      $query->where('primer_nombre', 'like', "%{$search}%")
                            ->orWhere('primer_apellido', 'like', "%{$search}%");
                  })
                  ->orWhereHas('medico', function ($query) use ($search) {
                      $query->where('nombre', 'like', "%{$search}%");
                  })
                  ->orWhereDate('fecha', '=', $search); // Filtrar por fecha exacta
        })
        ->paginate(10); // Cambia a 10 resultados por página

    return view('realizar_examenes.index', compact('realizarExamenes'));
}


    public function create()
{
    // Fetch all types of analysis
    $tipos_analisis = TipoAnalisis::all();
    
    // Fetch all exams
    $examenes = Examen::all();
    
    // Use pagination for better data loading
    $medicos = Medico::paginate(10);
    $pacientes = Patient::paginate(10);
    
    // Return the view with the data
    return view('realizar_examenes.create', compact('tipos_analisis', 'examenes', 'medicos', 'pacientes'));
}


    public function store(Request $request)
    {
        // Validar los datos de entrada
        $this->validateRequest($request);

        // Verificar si el usuario está autenticado
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Necesitas iniciar sesión para realizar esta acción.');
    }


        // Crear un nuevo examen
        RealizarExamen::create([
            'examen_id' => $request->examen_id,
            'usuario_id' => Auth::user()->id,
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'fecha' => $request->fecha,
            'status' => $request->status,
        ]);

        return redirect()->route('realizar_examenes.index')->with('success', 'Examen realizado exitosamente.');
    }

    public function edit($id)
{
    $realizarExamen = RealizarExamen::findOrFail($id); // Asegúrate de que estás utilizando el modelo correcto
    $examenes = Examen::all(); // Obtén la lista de exámenes
    $medicos = Medico::all(); // Obtén la lista de médicos
    $pacientes = Patient::all(); // Obtén la lista de pacientes
    $tipos_analisis = TipoAnalisis::all(); // Obtén la lista de tipos de análisis

     // Asegúrate de pasar el tipo de análisis del examen que se está editando
    $tipo_analisis_id = $realizarExamen->tipoAnalisis ? $realizarExamen->tipoAnalisis->id : null;

    return view('realizar_examenes.edit', compact('realizarExamen', 'examenes', 'medicos', 'pacientes', 'tipos_analisis'));
}


    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $this->validateRequest($request);

        // Actualizar el examen existente
        $realizarExamen = RealizarExamen::findOrFail($id);
        $realizarExamen->update([
            'examen_id' => $request->examen_id,
            'usuario_id' => Auth::user()->id,
            'paciente_id' => $request->paciente_id,
            'medico_id' => $request->medico_id,
            'fecha' => $request->fecha,
            'status' => $request->status,
        ]);

        return redirect()->route('realizar_examenes.index')->with('success', 'Examen actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $realizarExamen = RealizarExamen::findOrFail($id);
        $realizarExamen->delete();
        return redirect()->route('realizar_examenes.index')->with('success', 'Examen eliminado exitosamente.');
    }

    public function searchPacientes(Request $request)
    {
        $query = $request->input('query');
        // Filtrar pacientes por CUI, primer nombre o primer apellido
        $pacientes = Patient::where('cui', 'LIKE', "%$query%")
            ->orWhere('primer_nombre', 'LIKE', "%$query%")
            ->orWhere('primer_apellido', 'LIKE', "%$query%")
            ->get();

        return response()->json($pacientes);
    }

    public function searchMedicos(Request $request)
    {
        $query = $request->input('query');
        // Filtrar médicos por CUI o nombre
        $medicos = Medico::where('cui', 'LIKE', "%$query%")
            ->orWhere('nombre', 'LIKE', "%$query%")
            ->get();

        return response()->json($medicos);
    }

    public function subirResultado($id)
    {
        $realizarExamen = RealizarExamen::findOrFail($id);
        return view('resultados.create', compact('realizarExamen'));
    }

    public function mostrarExamenes($usuarioId)
    {
        // Obtener solo los exámenes del usuario seleccionado
        $realizarExamenes = RealizarExamen::where('usuario_id', $usuarioId)->get();
        return view('tu.vista', compact('realizarExamenes'));
    }

    // Método para validar el request
    private function validateRequest(Request $request)
    {
        $request->validate([
            'examen_id' => 'required|exists:examenes,id',
            'paciente_id' => 'required|exists:patients,id',
            'medico_id' => 'required|exists:medicos,id',
            'fecha' => 'required|date',
            'status' => 'required|in:pendiente,finalizado',
        ]);
    }

    public function getExamenes($tipo_analisis_id)
{
    $examenes = Examen::where('tipo_analisis_id', $tipo_analisis_id)->get();
    return response()->json(['examenes' => $examenes]);
}
}