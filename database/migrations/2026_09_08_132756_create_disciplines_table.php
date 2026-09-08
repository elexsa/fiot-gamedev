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
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();           // «Математика», «Рендер» тощо
            $table->unsignedTinyInteger('level')->default(1); // рівень Skill Tree 1-4
            $table->boolean('is_boss')->default(false);       // фінальні «босові» дисципліни
            $table->json('prerequisites')->nullable();        // [id, ...] — зв'язки на дереві навичок
            $table->string('syllabus_file')->nullable();      // завантажений силабус (PDF)
            $table->string('syllabus_url')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
