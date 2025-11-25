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
        if (! Schema::hasColumn('product_sale', 'product_lot_id')) {
            Schema::table('product_sale', function (Blueprint $table) {
                $table->foreignId('product_lot_id')
                    ->after('sale_id')
                    ->nullable()
                    ->constrained('product_lots')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_sale', function (Blueprint $table) {
            $table->dropForeign(['product_lot_id']);
            $table->dropColumn('product_lot_id');
        });
    }
};
