<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("name", 200);
            $table->string("iso3166_1_alpha2", 10)->nullable();
            $table->string("iso3166_1_alpha3", 10)->nullable();
            $table->string("iso3166_1_numeric", 10)->nullable();
            $table->string("ioc", 10)->nullable();
            $table->string("flips_10", 10)->nullable();
            $table->string("license_plate", 10)->nullable();
            $table->string("domain", 10)->nullable();
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
        Schema::dropIfExists('countries');
    }
};
