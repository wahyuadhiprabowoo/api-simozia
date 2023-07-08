<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balita', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anak');
            $table->string('nama_ibu');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->dateTime('tanggal_lahir');
            $table->integer('umur');
            $table->string('berat_badan',11);
            $table->string('panjang_badan',11);
            $table->integer('detak_jantung')->nullable()->default(0);
            $table->integer('sistolik')->nullable()->default(0);
            $table->integer('diastolik')->nullable()->default(0);
            $table->string('zscore_berat_badan',11);
            $table->string('zscore_panjang_badan',11);
            $table->string('klasifikasi_berat_badan');
            $table->string('klasifikasi_panjang_badan');
            $table->string('klasifikasi_detak_jantung')->nullable()->default("-");
            $table->unsignedBigInteger('posyandu_id');
            $table->unsignedBigInteger('puskesmas_id');

            $table->timestamps();
            $table->foreign('posyandu_id')->references('id')->on('posyandu')->onDelete('cascade');
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balita');
    }
}
