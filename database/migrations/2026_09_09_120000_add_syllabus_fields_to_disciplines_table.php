<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Поля під аналог syllabuses.ist.kpi.ua: навчальний план дисциплін.
     */
    public function up(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->string('cycle')->nullable()->after('category');            // цикл підготовки
            $table->unsignedSmallInteger('credits')->nullable()->after('cycle'); // кредити ЄКТС
            $table->unsignedSmallInteger('hours')->nullable()->after('credits');  // години
            $table->unsignedTinyInteger('semester')->nullable()->after('level');  // семестр 1-8
            $table->unsignedTinyInteger('course')->nullable()->after('semester');  // курс 1-4
            $table->string('study_form')->nullable()->after('course');            // форма навчання
            $table->string('teacher')->nullable()->after('study_form');           // викладач (вільний текст)
            $table->string('academic_year')->nullable()->after('teacher');        // навчальний рік
            $table->string('education_level')->nullable()->after('academic_year'); // бакалавр/магістр
            $table->boolean('is_elective')->default(false)->after('is_boss');     // вибіркова
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->dropColumn([
                'cycle', 'credits', 'hours', 'semester', 'course',
                'study_form', 'teacher', 'academic_year', 'education_level', 'is_elective',
            ]);
        });
    }
};
