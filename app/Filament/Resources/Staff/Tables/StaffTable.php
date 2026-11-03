<?php

namespace App\Filament\Resources\Staff\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StaffTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_name')
                    ->label('Прізвище')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->label("Ім'я")
                    ->searchable(),
                TextColumn::make('patronymic')
                    ->label('По батькові')
                    ->searchable(),
                ImageColumn::make('avatar')
                    ->label('Фото')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('scopus_url')
                    ->label('Посилання на Scopus'),
                TextColumn::make('orcid_url')
                    ->label('Посилання на Orcid'),
                TextColumn::make('wos_url')
                    ->label('Посилання на WoS'),
                TextColumn::make('scholar_url')
                    ->label('Посилання на Google Scholar'),
                TextColumn::make('intellect_url')
                    ->label('Посилання на Intellect'),
                IconColumn::make('is_published')
                    ->label('Опублікований профіль')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата оновлення')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('degree.name')
                    ->label('Науковий ступінь')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('academicRank.name')
                    ->label('Вчене звання')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position.name')
                    ->label('Посада')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
