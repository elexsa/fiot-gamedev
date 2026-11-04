<?php

namespace App\Filament\Resources\YearOfStudies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class YearOfStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Назва курсу навчання')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: 1 курс, 2 курс'),
                TextInput::make('level')
                    ->label('Номер курсу')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Наприклад: 1, 2'),
            ]);
    }
}
