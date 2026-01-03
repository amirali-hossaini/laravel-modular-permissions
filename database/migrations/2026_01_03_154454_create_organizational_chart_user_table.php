<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizational_chart_user', function (Blueprint $table) {
            $table->foreignId('organizational_chart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->primary(['organizational_chart_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizational_chart_user');
    }
};
