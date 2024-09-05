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
        Schema::create('ubinans', function (Blueprint $table) {
            $table->id();
            $table->string('indeks', 22)->nullable();
            $table->string('tabul', 6)->nullable();
            $table->string('tahun', 4)->nullable();
            $table->string('bulan', 2)->nullable();
            $table->string('prov', 256)->nullable();
            $table->string('kab', 256)->nullable();
            $table->string('kec', 256)->nullable();
            $table->string('lokasi', 256)->nullable();
            $table->string('kode_segmen', 9)->nullable();
            $table->string('kode_kabkota', 4)->nullable();
            $table->string('subsegmen', 2)->nullable();
            $table->string('fase', 2)->nullable();
            $table->string('strata', 2)->nullable();
            $table->string('nks', 10)->nullable();
            $table->string('pcs', 64)->nullable();
            $table->string('hp_pcs', 15)->nullable();
            $table->string('pms', 64)->nullable();
            $table->string('hp_pms', 15)->nullable();
            $table->string('bln', 10)->nullable();
            $table->integer('subround', false, true)->nullable();
            $table->string('jenis_ubin', 2)->nullable();
            $table->string('jenis_sampel', 1)->nullable();
            $table->timestamp('last_update')->useCurrent();
            $table->string('akun', 20)->nullable();
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
        Schema::dropIfExists('ubinans');
    }
};
