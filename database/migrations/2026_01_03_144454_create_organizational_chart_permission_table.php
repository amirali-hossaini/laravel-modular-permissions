<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizational_chart_permission', function (Blueprint $table) {
            $table->foreignId('organizational_chart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();

            $table->primary(['organizational_chart_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizational_chart_permission');
    }
};
