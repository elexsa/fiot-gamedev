<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {

            // 1. Drop columns
            $table->dropColumn(['specialty_code', 'degree']);

            // 2. Add new columns
            $table->date('start_date');
            $table->date('end_date');

            $table->string('external_link')->nullable();

            // 3. Create a calculated column (virtual column)
            // It will automatically connect the years, for example: "2025-2026"
            if (DB::getDriverName() === 'sqlite') {
                // Синтаксис для SQLite
                $table->string('academic_year')
                    ->virtualAs("strftime('%Y', start_date) || '-' || strftime('%Y', end_date)");
            } else {
                // Синтаксис для MySQL / MariaDB
                $table->string('academic_year')
                    ->virtualAs("CONCAT(YEAR(start_date), '-', YEAR(end_date))");
            }

            // 4. Add new foreign keys (ID and the connection itself)
            // First, create the ID columns themselves (the type must strictly match the primary key in the parent tables)
            $table->unsignedBigInteger('specialty_id');
            $table->unsignedBigInteger('degree_id');

            // Then explicitly describe the rules of foreign keys (Foreign Key Constraints)
            $table->foreign('specialty_id')
                ->references('id')
                ->on('specialties')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreign('degree_id')
                ->references('id')
                ->on('degrees')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->index(['is_published', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {

            $table->dropIndex(['is_published', 'start_date', 'end_date']);

            // 1. Delete foreign keys and ID columns
            $table->dropForeign(['specialty_id']);
            $table->dropColumn('specialty_id');

            $table->dropForeign(['degree_id']);
            $table->dropColumn('degree_id');

            // 2. Delete the added dates and the calculated column
            $table->dropColumn(['start_date', 'end_date', 'academic_year']);

            $table->dropColumn('external_link');

            // 3. Return old columns in case of rollback
            $table->string('specialty_code')->nullable();
            $table->string('degree')->nullable();
        });
    }
};
