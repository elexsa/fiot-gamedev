<?php

namespace App\Filament\Resources\StaffPositions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StaffPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Посада на кафедрі')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: Професор, Доцент'),
                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->placeholder('Наприклад: 1, 2'),
            ]);
    }
}
