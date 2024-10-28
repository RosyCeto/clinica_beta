<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Importa la clase Request
use Illuminate\Support\Facades\Storage; // Si usas el sistema de archivos de Laravel

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validar el archivo de imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Procesar la subida de la imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public'); // Almacena en la carpeta 'images' del disco 'public'

            return response()->json(['path' => $path], 201); // Usando la función response()
        }

        return response()->json(['message' => 'No se ha subido ninguna imagen'], 400);
    }
}
