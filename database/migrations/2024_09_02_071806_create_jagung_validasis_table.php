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
        Schema::create('jagung_validasis', function (Blueprint $table) {
            $table->id();
            $table->string('indeks', 10)->index(); // kolom 'indeks' dengan tipe varchar(10) dan index
            $table->integer('subsegmen_K'); // konsisten
            $table->integer('subsegmen_TK'); // tidak konsisten
            $table->integer('subsegmen_W'); // warning
            $table->integer('subsegmen_total'); // total
            $table->integer('segmen_K'); // konsisten
            $table->integer('segmen_TK'); // tidak konsisten
            $table->integer('segmen_total'); // total
            $table->integer('status_A'); // approved
            $table->integer('status_R'); // rejected
            $table->integer('status_total'); // total
            $table->integer('evita_A'); // approved
            $table->integer('evita_R'); // rejected
            $table->integer('evita_total'); // total
            $table->timestamp('last_update')->useCurrent(); // kolom 'last_update' dengan tipe datetime dan default current timestamp
            $table->string('akun', 20);
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
        Schema::dropIfExists('jagung_validasis');
    }
};
