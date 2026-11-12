<?php

namespace App\Filament\Resources\Programs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва освітньої програми')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Опис'),
                IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_external')
                    ->label('ОП іншої кафедри')
                    ->boolean()
                    ->sortable(),
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
                TextColumn::make('start_date')
                    ->label('Дата початку')
                    ->date('d.m.Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('Дата завершення')
                    ->date('d.m.Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('external_link')
                    ->label('Посилання на освітню програму (osvita.kpi.ua)'),
                TextColumn::make('academic_year')
                    ->label('Період навчання')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('specialty.specialty_code')
                    ->label('Код спеціальності')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('degree.name')
                    ->label('Рівень освіти')
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
