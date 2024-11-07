<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
       
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public'); 

            return response()->json(['path' => $path], 201);
        }

        return response()->json(['message' => 'No se ha subido ninguna imagen'], 400);
    }
}