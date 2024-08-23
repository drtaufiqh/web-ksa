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
            $table->string('pcs', 64)->nullable()->default(null);
            $table->string('a1', 2)->nullable()->default("0");
            $table->string('a2', 2)->nullable()->default("0");
            $table->string('a3', 2)->nullable()->default("0");
            $table->string('b1', 2)->nullable()->default("0");
            $table->string('b2', 2)->nullable()->default("0");
            $table->string('b3', 2)->nullable()->default("0");
            $table->string('c1', 2)->nullable()->default("0");
            $table->string('c2', 2)->nullable()->default("0");
            $table->string('c3', 2)->nullable()->default("0");
            $table->string('status', 20)->nullable()->default(null);
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
