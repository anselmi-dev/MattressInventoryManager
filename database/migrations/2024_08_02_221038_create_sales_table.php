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
            $table->string('CODFAC');
            $table->string('ESTFAC');
            $table->string('CLIFAC')->nullable();
            $table->string('CNOFAC')->nullable();
            $table->string('CEMFAC')->nullable();
            $table->string('TIPFAC')->nullable();
            $table->float('TOTFAC', precision: 53);
            $table->float('IREC1FAC', precision: 53);
            $table->float('NET1FAC', precision: 53);
            $table->float('IIVA1FAC', precision: 53);
            $table->timestamp('FECFAC');
            $table->timestamps();
        });
        
        Schema::create('product_sale', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->string('ARTLFA')->description('Código del artículo');
            $table->integer('CANLFA');
            $table->float('TOTLFA', precision: 53);
            $table->string('DESLFA')->nullable();
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
