<?php

use App\Models\Product;
use App\Models\ProductSale;
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
        Schema::create('special_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProductSale::class)->onDelete('cascade')->nullable();
            $table->foreignIdFor(Product::class)->onDelete('cascade')->nullable();
            $table->string('quantity')->description('Cantidad fabricada si es una medida especial')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_measurements');
    }
};
