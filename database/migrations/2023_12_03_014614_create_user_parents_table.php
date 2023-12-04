<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_parents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->string('kata_sandi');
            $table->string('ayah');
            $table->string('ibu');
            $table->string('wali')->nullable();
            $table->string('telepon_ayah');
            $table->string('telepon_ibu');
            $table->string('telepon_wali')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_parents');
    }
}
