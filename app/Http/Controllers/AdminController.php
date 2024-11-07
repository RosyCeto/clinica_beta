<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 

class AdminController extends Controller
{
    public function index()
    {

        $totalUsuarios = User::count();


        $nuevosUsuarios = User::where('created_at', '>=', now()->subMonth())->count();


        return view('admin-dashboard', compact('totalUsuarios', 'nuevosUsuarios'));
    }
}