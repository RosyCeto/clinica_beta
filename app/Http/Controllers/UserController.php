<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function edit($id)
{
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
}

public function toggleStatus($id)
{
    $user = User::findOrFail($id);
    $user->status = !$user->status;
    $user->save();

    // Cerrar sesión si el usuario se vuelve inactivo
    if (!$user->status && Auth::id() == $user->id) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada.');
    }

    return redirect()->route('users.index')->with('status', 'Estado del usuario actualizado correctamente.');
}


public function editImage($id)
{
    $user = User::findOrFail($id);
    return view('users.editImage', compact('user'));
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,doctor,nurse,lab_tech',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = new User($request->all());
    $user->password = Hash::make($request->password);
    $user->fecha_registro = Carbon::now();

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('fotos', 'public');
        $user->foto = $path;
    }

    $user->save();

    return redirect()->route('users.index')->with('status', 'Usuario creado correctamente.');
}


public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Validar los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        'role' => 'required|in:admin,doctor,nurse,lab_tech',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Actualizar los datos
    $user->update($request->except('foto'));

    // Manejar la imagen de perfil
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('fotos', 'public');
        $user->foto = $path;
        $user->save();
    }

    return redirect()->route('users.index')->with('status', 'Usuario actualizado correctamente.');
}

public function perfil()
    {
        $usuario = Auth::user();
        return view('perfil', compact('usuario'));
    }

    public function updateImage(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('fotos', 'public');
        $user->foto = $path;
        $user->save();
    }

    return redirect()->route('perfil')->with('status', 'Imagen actualizada correctamente.');
}



}
