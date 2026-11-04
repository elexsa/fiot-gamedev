<?php

namespace App\Filament\Resources\Semesters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SemesterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Назва семестру навчання')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: 1 семестр, 2 семестр'),
                TextInput::make('level')
                    ->label('Номер семестру')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Наприклад: 1, 2'),
            ]);
    }
}
