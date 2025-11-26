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
        Schema::create('product_sale_imports', function (Blueprint $table) {
            $table->id();
            $table->string('documento')->nullable();      // Documento
            $table->string('codigo')->nullable();         // Código
            $table->date('fecha')->nullable();            // Fecha
            $table->string('prov_cli')->nullable();       // Prov/Cli
            $table->string('serie_lote')->nullable();     // Serie/lote
            $table->string('articulo')->nullable();       // Artículo
            $table->integer('unidades')->nullable();      // Unidades
            $table->string('fabr_env')->nullable();       // Fabr/env
            $table->string('cons_pref')->nullable();      // Cons.pref.
            $table->string('status')->default('pending');         // Estado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sale_imports');
    }
};
