<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable(false);
            $table->unsignedSmallInteger('year_start')->nullable(false);
            $table->unsignedSmallInteger('year_end')->nullable(false);
            $table->foreignId('user_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('business_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credentials');
    }
};
