<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padi_amatans', function (Blueprint $table) {
            $table->id();
            $table->string('indeks', 20)->nullable()->default(null);
            $table->string('tabul', 6)->nullable()->default(null);
            $table->string('tahun', 4)->nullable()->default(null);
            $table->string('bulan', 2)->nullable()->default(null);
            $table->string('kode_segmen', 9)->nullable()->default(null);
            $table->string('kode_kabkota', 4)->nullable()->default(null);
            $table->string('pcs', 64)->nullable()->default(null);
            $table->string('a1', 2)->nullable()->default(null);
            $table->string('a2', 2)->nullable()->default(null);
            $table->string('a3', 2)->nullable()->default(null);
            $table->string('b1', 2)->nullable()->default(null);
            $table->string('b2', 2)->nullable()->default(null);
            $table->string('b3', 2)->nullable()->default(null);
            $table->string('c1', 2)->nullable()->default(null);
            $table->string('c2', 2)->nullable()->default(null);
            $table->string('c3', 2)->nullable()->default(null);
            $table->string('hasil_a1', 2)->nullable()->default(null);
            $table->string('hasil_a2', 2)->nullable()->default(null);
            $table->string('hasil_a3', 2)->nullable()->default(null);
            $table->string('hasil_b1', 2)->nullable()->default(null);
            $table->string('hasil_b2', 2)->nullable()->default(null);
            $table->string('hasil_b3', 2)->nullable()->default(null);
            $table->string('hasil_c1', 2)->nullable()->default(null);
            $table->string('hasil_c2', 2)->nullable()->default(null);
            $table->string('hasil_c3', 2)->nullable()->default(null);
            $table->string('status', 20)->nullable()->default(null);
            $table->string('evita', 20)->nullable()->default(null);
            $table->string('akun', 20)->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('padi_amatans');
    }
};
