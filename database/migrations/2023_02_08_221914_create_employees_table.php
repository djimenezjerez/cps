<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->unsignedBigInteger('phone')->nullable(true);
            $table->unsignedBigInteger('ci')->nullable(false);
            $table->string('ci_complement')->nullable(true);
            $table->unsignedTinyInteger('city_id')->nullable(true);
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete()->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
