<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            # Datos
            $table->json('carrito');
            $table->decimal('total', places: 2, total: 8)->default(0);
            $table->enum('estado', ['pendiente', 'procesado', 'preparado', 'enviado', 'en reparto', 'entregado'])->default('pendiente');

            # Datos cliente
            $table->string('nombre_com');
            $table->string('direccion_com');
            $table->string('codigo_postal_com');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
