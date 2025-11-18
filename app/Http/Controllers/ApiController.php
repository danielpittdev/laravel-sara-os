<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    // Tester
    public function test(Request $request)
    {
        return response()->json([
            'mensaje' => 'Prueba de API correcta.'
        ], 200);
    }
}
