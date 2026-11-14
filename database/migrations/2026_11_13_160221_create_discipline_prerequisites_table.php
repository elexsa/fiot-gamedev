<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discipline_prerequisites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discipline_id')->constrained('disciplines')->cascadeOnDelete();
            $table->foreignId('prerequisite_id')->constrained('disciplines')->cascadeOnDelete();
            $table->timestamps();

            // Запобігаємо дублюванню пар
            $table->unique(['discipline_id', 'prerequisite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipline_prerequisites');
    }
};
