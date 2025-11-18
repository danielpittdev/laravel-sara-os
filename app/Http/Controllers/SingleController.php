<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function usuario($id)
    {
        $usuario = Usuario::whereId($id)->first();
        return view('panel.single.single', compact('usuario'));
    }
}
