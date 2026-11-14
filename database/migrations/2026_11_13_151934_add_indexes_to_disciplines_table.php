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
        Schema::table('disciplines', function (Blueprint $table) {
            
            // Зовнішні ключі для фільтрів (суттєво прискорюють роботу where та whereHas)
            $table->index('program_id');
            $table->index('year_of_study_id');
            $table->index('semester_id');
            $table->index('mode_of_study_id');

            // Поля для сортування (start_date, end_date, name)
            $table->index(['start_date', 'end_date']);
            $table->index('academic_period'); // для фільтрації за навчальним періодом

            // Статус публікації (оскільки завжди використовується scope published())
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->dropIndex(['program_id']);
            $table->dropIndex(['year_of_study_id']);
            $table->dropIndex(['semester_id']);
            $table->dropIndex(['mode_of_study_id']);
            $table->dropIndex(['start_date', 'end_date']);
            $table->dropIndex(['academic_period']);
            $table->dropIndex(['is_published']);
        });
    }
};
