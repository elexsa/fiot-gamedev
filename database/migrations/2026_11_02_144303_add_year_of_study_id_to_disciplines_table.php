<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->foreignId('year_of_study_id')
                ->nullable()
                ->constrained('years_of_study')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('disciplines', function (Blueprint $table) {
            $table->dropForeign(['year_of_study_id']);
            $table->dropColumn('year_of_study_id');
        });
    }
};
