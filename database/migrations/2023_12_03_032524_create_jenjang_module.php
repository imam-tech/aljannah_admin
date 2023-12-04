<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenjangModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenjangs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
        });
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenjang_id');
            $table->string('nama');
        });
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenjang_id');
            $table->integer('level_id');
            $table->string('jurusan');
            $table->string('nama_kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jenjang_module');
    }
}
