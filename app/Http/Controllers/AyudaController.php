<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    /**
     * Muestra la vista principal de Ayuda.
     */
    public function index()
    {
        return view('admin.configuracion.ayuda.index');
    }
}
