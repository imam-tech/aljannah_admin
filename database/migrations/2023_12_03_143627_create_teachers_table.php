<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_lengkap');
            $table->string('nomor_induk_kependudukan');
            $table->string('email');
            $table->string('telepon');
            $table->string('jenis_kelamin');
            $table->integer('jabatan_id');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota_atau_kabupaten');
            $table->string('alamat');
            $table->string('agama');
            $table->string('kewarganegaraan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
