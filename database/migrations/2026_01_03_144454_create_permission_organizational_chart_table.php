<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_organizational_chart', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organizational_chart_id')->constrained()->cascadeOnDelete();

            $table->primary(['permission_id', 'organizational_chart_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permission_organizational_chart');
    }
};
