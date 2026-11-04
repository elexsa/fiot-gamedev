<?php

namespace App\Filament\Resources\Degrees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DegreeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Назва')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: Бакалавр, Магістр'),
                TextInput::make('level')
                    ->label('Рівень')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Наприклад: 1, 2'),
            ]);
    }
}
