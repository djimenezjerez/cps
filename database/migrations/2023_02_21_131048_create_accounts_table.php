<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name')->nullable(false);
            $table->string('code')->nullable(false);
            $table->timestamps();
            $table->unique(['code', 'business_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
