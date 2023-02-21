<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->unique();
            $table->unsignedBigInteger('nit')->nullable(true);
            $table->string('code')->nullable(true);
            $table->string('address')->nullable(true);
            $table->foreignId('ceo_id')->constrained('employees')->nullable(true)->restrictOnUpdate()->restrictOnDelete();
            $table->foreignId('contact_id')->constrained('employees')->nullable(true)->restrictOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('businesses');
    }
};
