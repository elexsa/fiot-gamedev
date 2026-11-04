<?php

namespace App\Filament\Resources\Specialties\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SpecialtyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('specialty_code')
                    ->required()
                    ->label('Код спеціальності')
                    ->maxLength(5)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: F2'),
                TextInput::make('specialty_name')
                    ->required()
                    ->label('Назва спеціальності')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: Інженерія програмного забезпечення'),
                Select::make('field_of_study_id')
                    ->relationship('fieldOfStudy', 'fieldOfStudy_code')
                    ->label('Код галузі знань')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
