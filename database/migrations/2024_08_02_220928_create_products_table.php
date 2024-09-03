<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Dimension;
use App\Models\Code;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->enum('type', ['top', 'base', 'cover', 'combination']);
            $table->foreignIdFor(Dimension::class)->onDelete('cascade');
            $table->boolean('visible')->default(true);
            $table->integer('stock')->default(0);
            $table->integer('minimum_order')->default(0);
            $table->boolean('minimum_order_notification_enabled')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
