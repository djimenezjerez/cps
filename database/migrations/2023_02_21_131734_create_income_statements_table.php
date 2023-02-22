<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income_statements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained()->nullable(false)->cascadeOnUpdate()->cascadeOnDelete();
            $table->float('subtotal', 12, 2)->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_statements');
    }
};
