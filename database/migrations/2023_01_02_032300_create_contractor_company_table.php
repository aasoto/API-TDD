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
        Schema::create('contractor_company', function (Blueprint $table) {
            $table->id();
            $table->string('nit', 100)->unique();
            $table->string('business_name', 500);
            $table->string('address', 500);
            $table->foreignId("country_id")->constrained();
            $table->text('tags')->nullable();
            $table->string('responsable', 500);
            $table->string('email', 1000);
            $table->string('phone', 500);
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
        Schema::dropIfExists('contractor_company');
    }
};
