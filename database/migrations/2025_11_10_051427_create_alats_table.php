<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alat')->unique();
            $table->string('jenis_alat');
            $table->string('nama_alat');
            $table->integer('persediaan_awal')->default(0);
            $table->integer('persediaan_gudang')->default(0);
            $table->integer('selisih')->virtualAs('persediaan_awal - persediaan_gudang');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
