<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments("id");
            $table->string('country');
            $table->string('province_name');
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('province_id');
            $table->string('type');
            $table->string('city_name');
            $table->string('postal_code');
        });

        Schema::create('subdistricts', function (Blueprint $table) {
            $table->increments("id");
            $table->integer('city_id');
            $table->string('subdistrict_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
