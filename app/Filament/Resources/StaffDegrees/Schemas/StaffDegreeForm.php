<?php

namespace App\Filament\Resources\StaffDegrees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StaffDegreeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Науковий ступінь')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: PhD'),
                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->placeholder('Наприклад: 1, 2'),
            ]);
    }
}
