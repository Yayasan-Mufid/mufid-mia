<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('kode');
            $table->string('email');
            $table->string('nama');
            $table->string('nohp_whatsapp');
            $table->string('nohp_telegram');
            $table->text('alamat')->nullable();
            $table->string('tgl_lahir')->nullable();
            $table->string('gender')->nullable(); // L - IKHWAN, P - AKHWAT
            $table->string('domisili')->nullable();
            $table->string('angkatan')->nullable();
            $table->integer('konfirmasi')->default(0); // JUMLAH KIRIM NOTIF KONFIRMASI
            $table->integer('tolak_tf')->default(0); // JUMLAH KIRIM NOTIF MENOLAK BUKTI TF
            $table->integer('status')->default(0); // 1 DAFTAR/MENUNGGU KONFIRMASI - 2 AKTIF - 3 TOLAK TF
            $table->string('bukti_tf')->nullable();
            $table->string('waktu_konfirmasi')->nullable();
            $table->string('waktu_tolak_tf')->nullable();
            $table->integer('nominal')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pendaftarans');
    }
}
