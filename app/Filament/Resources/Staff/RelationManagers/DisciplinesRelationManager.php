<?php

namespace App\Filament\Resources\Staff\RelationManagers;

use App\Models\Discipline;
use Carbon\Carbon;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DisciplinesRelationManager extends RelationManager
{
    protected static string $relationship = 'disciplines';

    protected static ?string $title = 'Дисципліни';

    public static function getModelLabel(): string
    {
        return 'дисципліну';
    }

    public static function getPluralModelLabel(): string
    {
        return 'дисципліни';
    }

    protected function getAvailableDisciplinesForAttach(?string $search, AttachAction $action): array
    {
        $ownerRecord = $action->getLivewire()->getOwnerRecord();

        $query = Discipline::query()
            ->with(['yearOfStudy', 'semester', 'modeOfStudy', 'program']);

        if ($ownerRecord) {
            // Отримуємо ID дисциплін, які викладач ВЖЕ викладає
            $excludedIds = $ownerRecord->disciplines()->pluck('disciplines.id')->toArray();

            if (!empty($excludedIds)) {
                $query->whereNotIn('disciplines.id', $excludedIds);
            }
        }

        // Пошук за назвою, якщо користувач вводить текст
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->limit(50)
            ->get()
            ->mapWithKeys(fn(Discipline $record) => [
                $record->id => $this->formatDisciplineLabel($record)
            ])
            ->all();
    }

    protected function formatDisciplineLabel(Discipline $record): string
    {
        return "{$record->name} [ID: {$record->id}, ({$record->start_date->toDateString()}, {$record->end_date->toDateString()})]"
            . ($record->yearOfStudy ? " ({$record->yearOfStudy->name})" : '')
            . ($record->semester ? " ({$record->semester->name})" : '')
            . ($record->modeOfStudy ? " ({$record->modeOfStudy->name})" : '')
            . ($record->program ? " ({$record->program->name}, {$record->program->start_date->toDateString()} - {$record->program->end_date->toDateString()})" : '');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Редагування відбувається у відповідному розділі
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('id')
                    ->label('Id дисципліни')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Назва дисципліни')
                    ->searchable()
                    ->sortable(),
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
                TextColumn::make('description')
                    ->label('Опис дисципліни')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('program.name')
                    ->label('Освітня програма')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('modeOfStudy.name')
                    ->label('Форма навчання')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('semester.name')
                    ->label('Семестр')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('yearOfStudy.name')
                    ->label('Курс навчання')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('credits')
                    ->label('Кредити')
                    ->placeholder('—'),
                TextColumn::make('hours')
                    ->label('Години')
                    ->placeholder('—'),
                IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean(),
                IconColumn::make('is_elective')
                    ->label('Вибіркова дисципліна')
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
                TextColumn::make('sort_order')
                    ->label('Порядок'),
            ])
            ->defaultSort('name', 'asc') // сортування дисциплін за назвою
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Прикріпити дисципліну')
                    ->recordTitleAttribute('name')
                    ->preloadRecordSelect()
                    ->form(fn(AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Дисципліна')
                            ->placeholder('Оберіть дисципліну зі списку...')

                            // 1. Динамічний пошук з виключенням вже прикріплених викладачу дисциплін
                            ->getSearchResultsUsing(fn(string $search) => $this->getAvailableDisciplinesForAttach($search, $action))

                            // 2. Початковий список опцій
                            ->options(fn() => $this->getAvailableDisciplinesForAttach(null, $action))

                            // 3. Коректне відображення вже обраного значення за ID
                            ->getOptionLabelUsing(function ($value): ?string {
                                $discipline = Discipline::with(['yearOfStudy', 'semester', 'modeOfStudy', 'program'])->find($value);

                                return $discipline ? $this->formatDisciplineLabel($discipline) : null;
                            }),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
