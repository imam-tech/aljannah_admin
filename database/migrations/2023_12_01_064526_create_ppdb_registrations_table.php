<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpdbRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nomor_pendaftaran");
            $table->string('jenis_pendaftaran');
            $table->string('status_pendaftaran');
            $table->string('status_pembayaran');
            $table->string('gelombang_pendaftaran');
            $table->string('jenjang');
            $table->string('jalur_pendaftaran');
            $table->string('nama_lengkap');
            $table->string('nomor_induk_kependudukan');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->decimal('berat_badan', 5, 1)->default(0);
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('nama_wali')->nullable();
            $table->string('telepon_ayah');
            $table->string('telepon_ibu');
            $table->string('telepon_wali')->nullable();
            $table->string('nama_sekolah_sebelumnya')->nullable();
            $table->string('status_sekolah_sebelumnya')->nullable();
            $table->string('alamat_sekolah_sebelumnya')->nullable();
            $table->string('tahun_lulus_sekolah_sebelumnya')->nullable();
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kota_atau_kabupaten');
            $table->string('provinsi');
            $table->string('kewarganegaraan');
            $table->string('jenis_tempat_tinggal')->nullable();
            $table->string('transportasi_ke_sekolah')->nullable();
            $table->string('jarak_ke_sekolah')->nullable();
            $table->string('waktu_tempuh_ke_sekolah')->nullable();
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
        Schema::dropIfExists('ppdb_registrations');
    }
}
