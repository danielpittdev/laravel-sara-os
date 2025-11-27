<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Articulo extends Model
{
    protected $table = 'articulos';

    protected $fillable = [
        'uuid',
        'nombre',
        'descripcion',
        'precio',
        'visible',
        'stock',
    ];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'articulo_id');
    }
}
