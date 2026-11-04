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
            $table->foreignId('mode_of_study_id')
                ->constrained('modes_of_study')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeof_studies');

        Schema::table('disciplines', function (Blueprint $table) {
            $table->dropForeign(['mode_of_study_id']);
            $table->dropColumn('mode_of_study_id');
        });
    }
};
