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
        Schema::create('petanis', function (Blueprint $table) {
            $table->id(); // id (Primary key)
            $table->string('kode_segmen', 9)->nullable(); // kode_segmen (Index)
            $table->string('subsegmen', 2)->nullable(); // subsegmen (Index)
            $table->string('nik', 16)->nullable(); // nik
            $table->string('nama', 200)->nullable(); // nama
            $table->text('alamat')->nullable(); // alamat
            $table->string('hp', 15)->nullable(); // hp
            $table->string('ktp', 22)->nullable(); // ktp
            $table->tinyInteger('status')->nullable(); // status (int(2))
            $table->timestamp('last_update')->useCurrent()->nullable(); // last_update
            $table->string('akun', 20)->nullable(); // akun
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
        Schema::dropIfExists('petanis');
    }
};
