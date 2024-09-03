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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('quantity');
            // $table->enum('type', ['product', 'combination'])->default('product');
            $table->enum('status', ['pending', 'processed', 'error'])->default('pending');
            $table->timestamps();
        });

        Schema::create('product_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sale');
        
        Schema::dropIfExists('sales');
    }
};
