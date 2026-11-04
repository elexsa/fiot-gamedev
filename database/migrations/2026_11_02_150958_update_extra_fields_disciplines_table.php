<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->dropColumn('category');
            $table->dropColumn('level');
            $table->dropColumn('is_boss');
            $table->dropColumn('prerequisites');
            $table->dropColumn('syllabus_file');
            $table->dropColumn('cycle');
            $table->dropColumn('semester');
            $table->dropColumn('course');
            $table->dropColumn('study_form');
            $table->dropColumn('teacher');
            $table->dropColumn('academic_year');
            $table->dropColumn('education_level');

            $table->date('start_date');
            $table->date('end_date');

            // Create a calculated column (virtual column)
            // It will automatically connect the years, for example: "2025-2026"
            if (DB::getDriverName() === 'sqlite') {
                // Синтаксис для SQLite (використовуємо strftime з %d.%m.%Y)
                $table->string('academic_period')
                    ->virtualAs("strftime('%d.%m.%Y', start_date) || '-' || strftime('%d.%m.%Y', end_date)");
            } else {
                // Синтаксис для MySQL / MariaDB (використовуємо DATE_FORMAT)
                $table->string('academic_period')
                    ->virtualAs("CONCAT(DATE_FORMAT(start_date, '%d.%m.%Y'), '-', DATE_FORMAT(end_date, '%d.%m.%Y'))");
            }
        });
    }

    public function down(): void {}
};
