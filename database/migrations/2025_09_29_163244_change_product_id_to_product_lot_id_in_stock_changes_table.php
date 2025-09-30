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
        Schema::table('stock_changes', function (Blueprint $table) {
            // Primero eliminar la foreign key existente
            $table->dropForeign(['product_id']);

            // Eliminar la columna product_id
            $table->dropColumn('product_id');

            // Agregar la nueva columna product_lot_id
            $table->foreignId('product_lot_id')->constrained()->onDelete('cascade')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_changes', function (Blueprint $table) {
            // Eliminar la foreign key de product_lot_id
            $table->dropForeign(['product_lot_id']);

            // Eliminar la columna product_lot_id
            $table->dropColumn('product_lot_id');

            // Restaurar la columna product_id original
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->after('id');
        });
    }
};
