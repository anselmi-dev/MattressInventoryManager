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
        Schema::create('factusol_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('ARTSTO');
            $table->string('ALMSTO');
            $table->float('MINSTO');
            $table->float('MAXSTO');
            $table->float('ACTSTO');
            $table->float('DISSTO');
            $table->string('UBISTO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factusol_product_stocks');
    }
};
