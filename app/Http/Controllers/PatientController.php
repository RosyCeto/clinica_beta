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

 
    $patients = Patient::query()
        ->when($search, function ($query) use ($search) {
            $query->where('primer_nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('segundo_nombre', 'LIKE', '%' . $search . '%')
                  ->orWhere('primer_apellido', 'LIKE', '%' . $search . '%')
                  ->orWhere('segundo_apellido', 'LIKE', '%' . $search . '%')
                  ->orWhere('cui', 'LIKE', '%' . $search . '%')
                  ->orWhere('nexpedientes', 'LIKE', '%' . $search . '%');
        })
        ->paginate(10); 


    if ($request->ajax()) {
        return response()->json([
            'patients' => $patients->items(),
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
            'escolaridad' => 'nullable|in:N/A,preprimaria,primaria,básico,diversificado,universidad,otro',
            'profesion' => 'nullable|string|max:250',
            'telefono' => 'nullable|string|max:8',
            'direccion' => 'nullable|string|max:250',
        ]);

        $data = $request->all();

        $data['segundo_nombre'] = $data['segundo_nombre'] ?? '';
        $data['segundo_apellido'] = $data['segundo_apellido'] ?? '';
        $data['apellido_casada'] = $data['apellido_casada'] ?? '';

        $data['discapacidad'] = isset($data['discapacidad']) && $data['discapacidad'] !== ''
            ? (is_array($data['discapacidad']) ? implode(',', $data['discapacidad']) : $data['discapacidad'])
            : null;

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Paciente creado con éxito.');
    }

    public function show(Patient $patient)
    {
      
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
      
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
{

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

  
    $data['discapacidad'] = isset($data['discapacidad']) ? implode(',', $data['discapacidad']) : null;


    $patient->update($data);

    session()->flash('success', 'El paciente ' . $patient->primer_nombre . ' ha sido modificado exitosamente.');

    return redirect()->route('patients.index');
}

    public function destroy(Patient $patient)
    {

        $patient->delete();

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