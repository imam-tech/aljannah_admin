<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpdbRegistrationProvenFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppdb_registration_proven_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ppdb_registration_id');
            $table->string('file_bukti_bayar');
            $table->string('nama_rekening_tujuan');
            $table->string('nomor_rekening_tujuan');
            $table->string('nama_rekening_pengirim');
            $table->string('nomor_rekening_pengirim');
            $table->timestamp('tanggal_bayar');
            $table->decimal('jumlah_bayar', 20,0);
            $table->string('status')->nullable();
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
        Schema::dropIfExists('ppdb_registration_proven_file');
    }
}
