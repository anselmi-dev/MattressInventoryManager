<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_lot_product_lot')) {
            Schema::dropIfExists('product_lot_product_lot');
        }

        Schema::create('product_lot_product_lot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_lot_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_product_lot_id')->constrained('product_lots')->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_lot_product_lot');
    }
};
