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
        Schema::create('factusol_products', function (Blueprint $table) {
            $table->id();
            $table->string('CODART');
            $table->string('EANART')->nullable();
            $table->string('EQUART')->nullable();
            $table->integer('CCOART')->nullable();
            $table->string('FAMART')->nullable();
            $table->integer('ACTSTO')->default(0);
            $table->string('DESART')->nullable();
            $table->string('DEEART')->nullable();
            $table->string('DETART')->nullable();
            $table->integer('PHAART')->default(0);
            $table->integer('TIVART')->default(0);
            $table->decimal('PCOART', 10, 2)->default(0.0);
            $table->decimal('DT0ART', 10, 2)->default(0.0);
            $table->decimal('DT1ART', 10, 2)->default(0.0);
            $table->decimal('DT2ART', 10, 2)->default(0.0);
            $table->dateTime('FALART')->nullable();
            $table->decimal('MDAART', 10, 2)->default(0.0);
            $table->string('UBIART')->nullable();
            $table->integer('UELART')->default(0);
            $table->decimal('UPPART', 10, 2)->default(0.0);
            $table->string('DIMART')->nullable();
            $table->string('MEMART')->nullable();
            $table->string('OBSART')->nullable();
            $table->integer('NPUART')->default(0);
            $table->integer('NIAART')->default(0);
            $table->integer('COMART')->default(0);
            $table->string('CP1ART')->nullable();
            $table->string('CP2ART')->nullable();
            $table->string('CP3ART')->nullable();
            $table->string('REFART')->nullable();
            $table->string('DLAART')->nullable();
            $table->decimal('IPUART', 10, 2)->default(0.0);
            $table->string('NCCART')->nullable();
            $table->string('CUCART')->nullable();
            $table->decimal('CANART', 10, 2)->default(0.0);
            $table->string('IMGART')->nullable();
            $table->integer('SUWART')->default(0);
            $table->string('DELART')->nullable();
            $table->string('DEWART')->nullable();
            $table->string('MEWART')->nullable();
            $table->integer('CSTART')->default(3);
            $table->string('IMWART')->nullable();
            $table->integer('STOART')->default(0);
            $table->dateTime('FUMART')->nullable();
            $table->decimal('PESART', 10, 2)->default(0.0);
            $table->integer('FTEART')->default(0);
            $table->string('ACOART')->nullable();
            $table->string('GARART')->nullable();
            $table->integer('UMEART')->default(0);
            $table->integer('TMOART')->default(1);
            $table->string('CONART')->nullable();
            $table->integer('TIV2ART')->default(0);
            $table->string('DE1ART')->nullable();
            $table->string('DE2ART')->nullable();
            $table->string('DE3ART')->nullable();
            $table->decimal('DFIART', 10, 2)->default(0.0);
            $table->integer('RPUART')->default(0);
            $table->decimal('RPFART', 10, 2)->default(0.0);
            $table->integer('RCUART')->default(0);
            $table->decimal('RCFART', 10, 2)->default(0.0);
            $table->string('MECART')->nullable();
            $table->integer('DSCART')->default(0);
            $table->integer('AMAART')->default(0);
            $table->decimal('CAEART', 10, 2)->default(0.0);
            $table->integer('UFSART')->default(0);
            $table->integer('IMFART')->default(0);
            $table->decimal('PFIART', 10, 2)->default(0.0);
            $table->integer('MPTART')->default(0);
            $table->string('CP4ART')->nullable();
            $table->string('CP5ART')->nullable();
            $table->integer('ORDART')->default(999999);
            $table->string('UEQART')->nullable();
            $table->integer('DCOART')->default(0);
            $table->string('FAVART')->nullable();
            $table->integer('DSTART')->default(0);
            $table->decimal('VEWART', 10, 2)->default(0.0);
            $table->string('URAART')->nullable();
            $table->decimal('VMPART', 10, 2)->default(0.0);
            $table->string('UR1ART')->nullable();
            $table->string('UR2ART')->nullable();
            $table->string('UR3ART')->nullable();
            $table->string('CN8ART')->nullable();
            $table->integer('OCUART')->default(0);
            $table->integer('RSVART')->default(0);
            $table->integer('NVSART')->default(0);
            $table->integer('DEPART')->default(0);
            $table->integer('SDEART')->default(0);
            $table->string('CASART')->nullable();
            $table->dateTime('HALART')->nullable();
            $table->integer('UALART')->default(0);
            $table->dateTime('HUMART')->nullable();
            $table->integer('UUMART')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factusol_products');
    }
};
