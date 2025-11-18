<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function inicio()
    {
        return view('web.inicio');
    }

    public function vitalic()
    {
        return view('web.vitalic');
    }

    # Vistas de AUTH

    // login
    public function login()
    {
        return view('auth.login');
    }

    // registro
    public function registro()
    {
        return view('auth.registro');
    }

    // recuperar
    public function recuperar()
    {
        return view('auth.recuperar');
    }

    // resetear
    public function resetear($id)
    {
        return view('auth.resetear', compact('id'));
    }
}
