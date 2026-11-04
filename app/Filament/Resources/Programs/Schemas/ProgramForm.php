<?php

namespace App\Filament\Resources\Programs\Schemas;

use App\Models\Program;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва освітньої програми')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($set, ?string $state, $record) {

                        // Перевірка порожнього значення
                        if (blank($state)) {
                            $set('slug', '');

                            return;
                        }

                        $baseSlug = Str::slug($state);

                        // Перевіряємо, чи існує вже такий slug у базі даних
                        // (Виключаємо поточний запис $record, якщо ми редагуємо програму)
                        $slugExists = Program::where('slug', $baseSlug)
                            ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                            ->exists();

                        if ($slugExists) {
                            // Якщо slug зайнятий, миттєво додаємо випадковий хеш
                            $set('slug', $baseSlug.'-'.strtolower(Str::random(4)));
                        } else {
                            // Якщо slug вільний, залишаємо його чистим
                            $set('slug', $baseSlug);
                        }
                    }),
                TextInput::make('slug')
                    ->label('URL (slug)')
                    ->required()
                    ->disabled()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Опубліковано')
                    ->default(true),
                DatePicker::make('start_date')
                    ->label('Дата початку')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Дата завершення')
                    ->required(),
                TextInput::make('external_link')
                    ->label('Посилання на освітню програму (osvita.kpi.ua)'),
                Select::make('specialty_id')
                    ->relationship('specialty', 'specialty_code')
                    ->label('Код спеціальності')
                    ->required(),
                Select::make('degree_id')
                    ->relationship('degree', 'name')
                    ->label('Рівень освіти')
                    ->required(),
            ]);
    }
}
