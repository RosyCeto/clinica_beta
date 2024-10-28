<?php

namespace App\Http\Controllers;

use App\Models\ResultadosLaboratorio;
use App\Models\RealizarExamen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultadosLaboratorioController extends Controller
{
    // Método para mostrar la lista de resultados
    public function index(Request $request)
{
    $query = RealizarExamen::with('usuario', 'paciente', 'medico', 'examen.tipoAnalisis', 'resultadoLaboratorio');

    // Filtrar por los parámetros de búsqueda
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('id', 'like', "%$search%")
              ->orWhereHas('usuario', function($q) use ($search) {
                  $q->where('name', 'like', "%$search%");
              })
              ->orWhereHas('paciente', function($q) use ($search) {
                  $q->where('primer_nombre', 'like', "%$search%")
                    ->orWhere('primer_apellido', 'like', "%$search%");
              })
              ->orWhereHas('medico', function($q) use ($search) {
                  $q->where('nombre', 'like', "%$search%");
              })
              ->orWhere('fecha', 'like', "%$search%");
    }

    // Aplicar paginación de 10 resultados por página
    $realizarExamenes = $query->paginate(10);

    return view('resultados.index', compact('realizarExamenes'));
}


    // Método para mostrar el formulario de creación de un nuevo resultado de laboratorio
    public function create($realizarExamenId)
    {
        return view('resultados.create', ['realizar_examen_id' => $realizarExamenId]);
    }

    // Método para guardar un nuevo resultado de laboratorio
    public function store(Request $request)
    {
        $request->validate([
            'realizar_examen_id' => 'required|exists:realizar_examenes,id',
            'archivo' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'comentarios' => 'nullable|string',
        ]);

        // Almacenar el archivo en el sistema
        $archivoPath = $request->file('archivo')->store('resultados_examenes', 'public');

        // Crear un nuevo resultado de laboratorio
        ResultadosLaboratorio::create([
            'realizar_examen_id' => $request->realizar_examen_id,
            'archivo' => $archivoPath,
            'comentarios' => $request->comentarios,
            'estado' => 'finalizado', 
        ]);

        // Actualizar el estado del examen relacionado a "finalizado"
        RealizarExamen::findOrFail($request->realizar_examen_id)->update(['status' => 'finalizado']);

        return redirect()->route('realizar_examenes.index')->with('success', 'Resultado subido y examen finalizado correctamente.');
    }

    // Método para mostrar el formulario de edición de un resultado de laboratorio
    public function edit($id)
{
    $resultado = ResultadosLaboratorio::findOrFail($id);
    return view('resultados.edit', compact('resultado'));
}

    // Método para actualizar un resultado de laboratorio existente
    public function update(Request $request, $id)
{
    $request->validate([
        'comentarios' => 'nullable|string',
        'archivo' => 'nullable|file|mimes:pdf,jpg,png|max:2048', 
    ]);

    $resultado = ResultadosLaboratorio::findOrFail($id);
    $resultado->comentarios = $request->comentarios;

    // Manejo del archivo
    if ($request->hasFile('archivo')) {
        // Eliminar el archivo viejo
        if (Storage::disk('public')->exists($resultado->archivo)) {
            Storage::disk('public')->delete($resultado->archivo);
        }
        // Guardar el nuevo archivo
        $path = $request->file('archivo')->store('resultados', 'public');
        $resultado->archivo = $path;
    }

    $resultado->save();

    return redirect()->route('resultados.index')->with('success', 'Resultado actualizado con éxito.');
}



    // Método para eliminar un resultado de laboratorio
    public function destroy($id)
    {
        $resultado = ResultadosLaboratorio::findOrFail($id);

        if (Storage::disk('public')->exists($resultado->archivo)) {
            Storage::disk('public')->delete($resultado->archivo);
        }

        $resultado->delete();

        return redirect()->route('resultados.index')->with('success', 'Resultado eliminado correctamente.');
    }

    // Método para mostrar un resultado de laboratorio específico
    public function show($id)
    {
        $examen = RealizarExamen::with('resultadoLaboratorio')->findOrFail($id);
        return view('resultados.show', compact('examen'));
    }

    // Método para obtener los resultados de laboratorio específicos de un examen
    public function getResultadosLaboratorio($examenId)
    {
        $resultados = ResultadosLaboratorio::where('realizar_examen_id', $examenId)->with('realizarExamen')->get();

        if ($resultados->isEmpty()) {
            return response()->json(['resultados' => [], 'mensaje' => 'No se encontraron resultados.']);
        }

        return response()->json(['resultados' => $resultados]);
    }
}
