<?php

namespace App\Filament\Resources\ModeofStudies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ModeofStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Назва форми навчання')
                    ->required()
                    ->maxLength(255),
                TextInput::make('sort_order')
                    ->label('Порядок сортування')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
