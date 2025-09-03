<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\ProductLot;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class, 'product_id')->onDelete('cascade');
            $table->foreignIdFor(ProductLot::class, 'product_lot_id')->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->unique(['product_id', 'product_lot_id'], 'unique_product_part');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_parts');
    }
};
