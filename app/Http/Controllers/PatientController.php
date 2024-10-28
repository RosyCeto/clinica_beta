<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index(Request $request)
{
    $search = $request->query('search');

    // Realiza la consulta de pacientes con búsqueda
    $patients = Patient::query()
        ->when($search, function ($query) use ($search) {
            $query->where('primer_nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('segundo_nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('primer_apellido', 'LIKE', '%' . $search . '%')
                  ->orWhere('segundo_apellido', 'LIKE', '%' . $search . '%')
                  ->orWhere('cui', 'LIKE', '%' . $search . '%')
                  ->orWhere('nexpedientes', 'LIKE', '%' . $search . '%');
        })
        ->paginate(10); // Aplica paginación de 10 pacientes por página

    // Verifica si la solicitud es AJAX
    if ($request->ajax()) {
        return response()->json([
            'patients' => $patients->items(), // Obtén los elementos paginados
            'pagination' => [
                'total' => $patients->total(),
                'current_page' => $patients->currentPage(),
                'last_page' => $patients->lastPage(),
                'per_page' => $patients->perPage(),
                'from' => $patients->firstItem(),
                'to' => $patients->lastItem(),
            ],
        ]);
    }

    return view('patients.index', compact('patients'));
}


    public function create()
    {
        $patients = Patient::all();
        return view('patients.create', compact('patients'));
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'cui' => 'nullable|string|max:13',
            'nexpedientes' => 'required|string|max:255',
            'primer_nombre' => 'required|string|max:200',
            'segundo_apellido' => 'nullable|string|max:200',
            'primer_apellido' => 'required|string|max:200',
            'segundo_apellido' => 'nullable|string|max:200',
            'apellido_casada' => 'nullable|string|max:200',
            'gender' => 'required|in:masculino,femenino',
            'etnia' => 'required|in:ladina,maya,xinca,garifuna,other',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|string|max:200',
            'discapacidad' => 'nullable|array',
            'discapacidad.*' => 'string|max:255',
            'escolaridad' => 'required|in:N/A,preprimaria,primaria,básico,diversificado,universidad,otro',
            'profesion' => 'nullable|string|max:250',
            'telefono' => 'nullable|string|max:8',
            'direccion' => 'nullable|string|max:250',
        ]);

        // Recolecta los datos del formulario
        $data = $request->all();

        // Asegúrate de que 'segundo_nombre', 'segundo_apellido' y 'apellido_casada' tengan valores por defecto
        $data['segundo_nombre'] = $data['segundo_nombre'] ?? '';
        $data['segundo_apellido'] = $data['segundo_apellido'] ?? '';
        $data['apellido_casada'] = $data['apellido_casada'] ?? '';

        // Asegúrate de que 'discapacidad' sea un string o nulo
        $data['discapacidad'] = isset($data['discapacidad']) && $data['discapacidad'] !== ''
            ? (is_array($data['discapacidad']) ? implode(',', $data['discapacidad']) : $data['discapacidad'])
            : null;

        // Almacenar el paciente
        Patient::create($data);

        // Redireccionar con mensaje de éxito
        return redirect()->route('patients.index')->with('success', 'Paciente creado con éxito.');
    }

    public function show(Patient $patient)
    {
        // Mostrar los detalles de un paciente específico
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        // Mostrar el formulario de edición de un paciente específico
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
{
    // Validate the input data
    $request->validate([
        'cui' => 'nullable|string|max:13',
        'nexpedientes' => 'required|string|max:255',
        'primer_nombre' => 'required|string|max:200',
        'segundo_nombre' => 'nullable|string|max:200',
        'primer_apellido' => 'required|string|max:200',
        'segundo_apellido' => 'nullable|string|max:200',
        'apellido_casada' => 'nullable|string|max:200',
        'gender' => 'required|in:masculino,femenino',
        'etnia' => 'required|in:ladina,maya,xinca,garifuna,other',
        'fecha_nacimiento' => 'required|date',
        'edad' => 'required|string|max:200',
        'discapacidad' => 'nullable|array',
        'discapacidad.*' => 'string|max:255',
        'escolaridad' => 'required|in:N/A,preprimaria,primaria,basico,diversificado,universidad,otro',
        'profesion' => 'nullable|string|max:250',
        'telefono' => 'nullable|string|max:8',
        'direccion' => 'required|string|max:250',
    ]);

    $data = $request->all();

    // Check if 'discapacidad' exists and convert it to a comma-separated string if it does
    $data['discapacidad'] = isset($data['discapacidad']) ? implode(',', $data['discapacidad']) : null;

    // Update the patient record
    $patient->update($data);

    session()->flash('success', 'El paciente ' . $patient->primer_nombre . ' ha sido modificado exitosamente.');

    return redirect()->route('patients.index');
}


    public function destroy(Patient $patient)
    {
        // Eliminar un paciente específico
        $patient->delete();

        // Configurar encabezados para evitar caché
        return redirect()->route('patients.index')->with('success', 'Paciente eliminado correctamente')->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $pacientes = Patient::where('primer_nombre', 'like', "%{$query}%")
                            ->orWhere('primer_apellido', 'like', "%{$query}%")
                            ->orWhere('cui', 'like', "%{$query}%")
                            ->orWhere('nexpedientes', 'like', "%{$query}%")
                            ->get();

        return response()->json($pacientes);
    }
}
