<?php

use App\Models\Product;
use App\Models\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'canceled', 'shipped', 'processed', 'error'])->default('pending');
            $table->string('email');
            $table->integer('sent_email_id')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
            $table->softDeletes();            
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->onDelete('cascade');
            $table->foreignIdFor(Order::class)->onDelete('cascade');
            $table->enum('status', ['pending', 'processed'])->default('pending');
            $table->integer('quantity');
            $table->integer('return')->default(0);
            $table->json('attribute_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('orders');
    }
};
