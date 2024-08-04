<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\{
    Dimension,
};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mattresses', function (Blueprint $table) {
            $table->id();
            
            $table->string('code')->nullable();

            $table->foreignIdFor(Dimension::class);

            $table->integer('stock')->default(0);

            $table->boolean('available')->default(true);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattresses');
    }
};
