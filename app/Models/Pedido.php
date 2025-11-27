<?php

namespace App\Models;

use App\Models\Articulo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'uuid',
        'carrito',
        'total',
        'estado',
        'nombre_com',
        'direccion_com',
        'codigo_postal_com'
    ];
}
