<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Досягнення працівників
        Schema::create('staff_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->unsignedSmallInteger('year'); // Рік досягнення
            $table->text('achievement_description'); // Опис досягнення
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('staff_achievements');
    }
};
