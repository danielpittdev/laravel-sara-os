<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecursosController extends Controller
{
    // Cerrar sesión
    public function cerrar_sesion()
    {
        return 'cerrar sesión';
    }

    // Barra de búsqueda
    public function busqueda(Request $request)
    {
        return $request;
    }
}
