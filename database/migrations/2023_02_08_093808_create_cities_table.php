<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name')->nullable(false);
            $table->string('code')->nullable(false)->unique();
            $table->unsignedTinyInteger('order')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
