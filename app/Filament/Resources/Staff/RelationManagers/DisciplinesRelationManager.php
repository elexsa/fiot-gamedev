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

    protected function getAvailableDisciplinesQuery(?string $search = null)
    {
        $query = Discipline::query()
            ->whereNotIn('id', $this->getOwnerRecord()->disciplines()->pluck('disciplines.id'))
            // Фільтр: поточна дата в межах start_date та end_date
            // ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now());

        // Якщо передано пошуковий запит — додаємо умову пошуку
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query
            ->orderBy('name')
            ->limit(100)
            ->pluck('name', 'id')
            ->mapWithKeys(fn ($name, $id) => [$id => "{$name} (ID: {$id})"])
            ->all();
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
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->label('Дисципліна')
                            ->placeholder('Оберіть дисципліну зі списку...')
                            // 1. Динамічний пошук (працює при введенні тексту)
                            ->getSearchResultsUsing(
                                fn (string $search): array => $this->getAvailableDisciplinesQuery($search)
                            )
                            // 2. Початковий список опцій (при відкритті списку)
                            ->options(
                                $this->getAvailableDisciplinesQuery()
                            )
                            // 3. Коректне відображення вже обраного значення з ID
                            ->getOptionLabelUsing(
                                fn ($value): ?string => ($discipline = Discipline::find($value))
                                    ? "{$discipline->name} (ID: {$discipline->id})"
                                    : null
                            ),
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
