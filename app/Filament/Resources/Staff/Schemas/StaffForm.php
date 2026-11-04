<?php

namespace App\Filament\Resources\Staff\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('last_name')
                    ->label('Прізвище')
                    ->required(),
                TextInput::make('first_name')
                    ->label("Ім'я")
                    ->required(),
                TextInput::make('patronymic')
                    ->label('По батькові'),
                FileUpload::make('avatar')
                    ->label('Фото (аватар)')
                    ->image()
                    ->directory('staff')
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor(),
                // ->columnSpanFull(),
                TextInput::make('scopus_url')
                    ->label('Посилання Scopus')
                    ->url(),
                TextInput::make('orcid_url')
                    ->label('Посилання Orcid')
                    ->url(),
                TextInput::make('wos_url')
                    ->label('Посилання WoS')
                    ->url(),
                TextInput::make('scholar_url')
                    ->label('Посилання Google Scholar')
                    ->url(),
                TextInput::make('intellect_url')
                    ->label('Посилання Intellect KPI')
                    ->url(),
                Textarea::make('bio')
                    ->label('Про викладача')
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Опублікований профіль')
                    ->required(),
                Select::make('degree_id')
                    ->relationship('degree', 'name')
                    ->label('Науковий ступінь')
                    ->searchable()
                    ->preload(),
                Select::make('academic_rank_id')
                    ->relationship('academicRank', 'name')
                    ->label('Вчене звання')
                    ->searchable()
                    ->preload(),
                Select::make('position_id')
                    ->relationship('position', 'name')
                    ->label('Посада')
                    ->searchable()
                    ->preload(),
            ]);
    }
}
