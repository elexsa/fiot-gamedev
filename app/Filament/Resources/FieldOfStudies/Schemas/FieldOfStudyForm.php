<?php

namespace App\Filament\Resources\FieldOfStudies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FieldOfStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fieldOfStudy_code')
                    ->required()
                    ->label('Код галузі знань')
                    ->maxLength(5)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: F'),
                TextInput::make('fieldOfStudy_name')
                    ->required()
                    ->label('Назва галузі знань')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Наприклад: Інформаційні технології'),
            ]);
    }
}
