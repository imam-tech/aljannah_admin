<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaliKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tahun_ajaran');
            $table->integer('kelas_id');
            $table->integer('teacher_id');
            $table->string('status');
            $table->timestamps();
        });

        Schema::table('kelas', function (Blueprint $table) {
            $table->integer('wali_kelas_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wali_kelas');
    }
}
