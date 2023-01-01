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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('cc', 100)->unique();
            $table->string('first_name', 200);
            $table->string('second_name', 200)->nullable();
            $table->string('last_name', 200);
            $table->string('second_last_name', 200)->nullable();
            $table->enum('gender', ['m', 'f', 'o', 'ne'])->nullable();
            $table->date('birthdate');
            $table->text('profile_photo')->nullable();
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
        Schema::dropIfExists('employee');
    }
};
