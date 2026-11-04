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
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('specialty_code')->unique();
            $table->string('specialty_name');

            $table->unsignedBigInteger('field_of_study_id');
            $table->foreign('field_of_study_id')
                ->references('id')
                ->on('fields_of_study')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialties');
    }
};
