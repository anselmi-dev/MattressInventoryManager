<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\{
    Cover,
    Mattress,
    Top
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
            
            $table->string('code')->nullable();
            
            $table->string('name')->nullable();

            $table->foreignIdFor(Mattress::class);

            $table->foreignIdFor(Cover::class);
            
            $table->foreignIdFor(Top::class);

            $table->integer('stock')->default(0);

            $table->timestamps();

            $table->softDeletes();
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
