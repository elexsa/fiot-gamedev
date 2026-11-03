<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Посада на кафедрі
        Schema::create('staff_positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedInteger('sort_order')->default(0); // Порядок для сортування
            $table->timestamps();

            // Сортування за полем
            $table->index('sort_order');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('staff_positions');
    }
};
