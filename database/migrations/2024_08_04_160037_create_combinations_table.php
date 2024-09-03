<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\{
    Dimension,
    Product,
    Combination,
    Code
};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'combined_product_id')->onDelete('cascade');
            $table->foreignIdFor(Product::class, 'product_id')->onDelete('cascade');
            $table->unique(['combined_product_id', 'product_id'], 'unique_combination_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combinations');
    }
};
