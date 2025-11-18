<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    // Inicio
    public function inicio()
    {
        return view('panel.inicio');
    }

    ### OTRAS PAGINAS ###
    // // pagina
    // public function pagina()
    // {
    //     return view('panel.pagina');
    // }

    // usuarios
    public function usuarios()
    {
        return view('panel.usuarios');
    }

    // Ajustes
    public function ajustes()
    {
        return view('panel.ajustes');
    }
}
