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
        // Renombrar la tabla sales a factusol_sales
        Schema::rename('sales', 'factusol_sales');

        // Actualizar la clave foránea en product_sale para que apunte a factusol_sales
        Schema::table('product_sale', function (Blueprint $table) {
            // Primero eliminar la clave foránea existente
            $table->dropForeign(['sale_id']);
        });

        // Recrear la clave foránea para que apunte a la nueva tabla
        Schema::table('product_sale', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('factusol_sales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la clave foránea de product_sale
        Schema::table('product_sale', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
        });

        // Recrear la clave foránea original
        Schema::table('product_sale', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
        });

        // Renombrar la tabla factusol_sales de vuelta a sales
        Schema::rename('factusol_sales', 'sales');
    }
};
