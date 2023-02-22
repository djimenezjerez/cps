<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credential_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedSmallInteger('name')->nullable(false);
            $table->float('total_income_statement', 12, 2)->nullable(false)->default(0);
            $table->timestamps();
            $table->unique(['name', 'credential_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('years');
    }
};
