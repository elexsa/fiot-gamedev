<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Працівники кафедри
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');              // Прізвище
            $table->string('first_name');             // Ім'я
            $table->string('patronymic')->nullable(); // По батькові
            $table->string('avatar')->nullable();     // Фото викладача (посилання)

            // Посилання на наукові профілі
            $table->string('scopus_url')->nullable();
            $table->string('orcid_url')->nullable();
            $table->string('wos_url')->nullable();
            $table->string('scholar_url')->nullable();
            $table->string('intellect_url')->nullable();

            // Текстові блоки
            $table->text('bio')->nullable();          // Біографія / Про викладача
            $table->boolean('is_published')->default(true);

            $table->timestamps();

            $table->foreignId('degree_id')->nullable()->constrained('staff_degrees')->nullOnDelete();
            $table->foreignId('academic_rank_id')->nullable()->constrained('staff_academic_ranks')->nullOnDelete();
            $table->foreignId('position_id')->nullable()->constrained('staff_positions')->nullOnDelete();

            // 1. Індекс для фільтрації та сортування за статусом публікації
            $table->index('is_published');

            // 2. Складений індекс для швидкого сортування за ПІБ (Прізвище + Ім'я)
            $table->index(['last_name', 'first_name']);

            // 3. Індекси для зв'язків (зовнішні ключі), які беруть участь у join та order by
            $table->index('position_id');
            $table->index('degree_id');
            $table->index('academic_rank_id');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
