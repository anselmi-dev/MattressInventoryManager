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
            
            $table->foreignIdFor(Dimension::class)->onDelete('cascade');

            $table->string('name')->nullable();

            $table->text('note')->nullable();

            $table->integer('stock')->default(0);

            $table->timestamps();

            $table->softDeletes();
        });

        Schema::create('combination_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->onDelete('cascade');
            $table->foreignIdFor(Combination::class)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combination_product');

        Schema::dropIfExists('combinations');
    }
};
