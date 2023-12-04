<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_induk_siswa')->nullable();
            $table->string('nomor_induk_siswa_nasional')->nullable();
            $table->string('nama');
            $table->string('angkatan');
            $table->string('jenjang');
            $table->string('level');
            $table->string('kelas');
            $table->string('nama_kelas');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('student_ppdb_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('ppdb_registration_id');
        });

        Schema::create('student_upgrade_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->string('jenjang_sebelumnya')->nullable();
            $table->string('level_sebelumnya')->nullable();
            $table->string('kelas_sebelumnya')->nullable();
            $table->string('jenjang_selanjutnya');
            $table->string('level_selanjutnya');
            $table->string('kelas_selanjutnya');
            $table->string('tahun');
        });

        Schema::create('student_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota_atau_kabupaten');
            $table->string('provinsi');
            $table->string('kewarganegaraan');
            $table->string('jenis_tempat_tinggal')->nullable();
            $table->string('transportasi_ke_sekolah')->nullable();
            $table->string('jarak_ke_sekolah')->nullable();
            $table->string('waktu_tempuh_ke_sekolah')->nullable();
            $table->decimal('berat_badan', 5,1)->nullable();
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
        Schema::dropIfExists('students');
    }
}
