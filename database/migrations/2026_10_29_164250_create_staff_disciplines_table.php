<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Таблиця дисциплін, які викладають працівники
        Schema::create('staff_disciplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('discipline_id')->constrained('disciplines')->cascadeOnDelete();
            $table->timestamps();

            // ГОЛОВНЕ: забороняємо дублювання пари викладач-дисципліна
            $table->unique(['staff_id', 'discipline_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('staff_disciplines');
    }
};
