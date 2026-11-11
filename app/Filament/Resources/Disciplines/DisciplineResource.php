<?php

namespace App\Filament\Resources\Disciplines;

use App\Filament\Resources\Disciplines\Pages\ManageDisciplines;
use App\Models\Discipline;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class DisciplineResource extends Resource
{
    protected static ?string $model = Discipline::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $pluralModelLabel = 'Дисципліни';

    protected static ?string $modelLabel = 'Дисципліна';

    protected static string|UnitEnum|null $navigationGroup = 'Освіта';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. Поле для вибору шаблону (працює лише при створенні)
                Select::make('template_discipline_id')
                    ->label('Завантажити дані з шаблону (існуючої дисципліни)')
                    ->options(
                        Discipline::with(['modeOfStudy', 'semester', 'yearOfStudy'])
                            ->latest()
                            ->get()
                            ->mapWithKeys(function ($discipline) {
                                // Збираємо додаткові деталі в масив і фільтруємо пусті значення
                                $details = collect([
                                    $discipline->yearOfStudy?->name,
                                    $discipline->semester?->name,
                                    $discipline->modeOfStudy?->name,
                                    $discipline->start_date ? 'з '.$discipline->start_date->format('d.m.Y') : null,
                                    $discipline->end_date ? 'по '.$discipline->end_date->format('d.m.Y') : null,
                                ])->filter()->implode(', ');

                                // Формуємо підсумковий текст для опції (наприклад: "Вища математика (1 курс, 1 семестр, Денна, з 01.09.2026 по 31.01.2027)")
                                $label = $discipline->name.($details ? " ({$details})" : '');

                                return [$discipline->id => $label];
                            })
                    )
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть дисципліну-шаблон для автоматичного заповнення')
                    ->live()
                    ->afterStateUpdated(function ($state, $set) {
                        if (! $state) {
                            return;
                        }

                        $discipline = Discipline::find($state);

                        if ($discipline) {
                            $set('program_id', $discipline->program_id);
                            $set('mode_of_study_id', $discipline->mode_of_study_id);
                            $set('semester_id', $discipline->semester_id);
                            $set('year_of_study_id', $discipline->year_of_study_id);
                            $set('start_date', $discipline->start_date ? Carbon::parse($discipline->start_date)->format('Y-m-d') : null);
                            $set('end_date', $discipline->end_date ? Carbon::parse($discipline->end_date)->format('Y-m-d') : null);
                            $set('name', $discipline->name);
                            $set('description', $discipline->description);
                            $set('credits', $discipline->credits);
                            $set('hours', $discipline->hours);
                            $set('is_elective', $discipline->is_elective);
                            $set('is_published', $discipline->is_published);
                            $set('sort_order', $discipline->sort_order);
                        }
                    })
                    ->dehydrated(false)
                    ->hiddenOn('edit')
                    ->columnSpanFull(),

                // 2. Основні поля форми
                Select::make('program_id')
                    ->label('Освітня програма')
                    ->relationship('program', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->start_date?->format('d.m.Y')} - {$record->end_date?->format('d.m.Y')})")
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть освітню програму'),

                Select::make('mode_of_study_id')
                    ->label('Форма навчання')
                    ->relationship('modeOfStudy', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть форму навчання')
                    ->required(),

                Select::make('semester_id')
                    ->label('Семестр')
                    ->relationship('semester', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть семестр')
                    ->required(),

                Select::make('year_of_study_id')
                    ->label('Курс навчання')
                    ->relationship('yearOfStudy', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть курс')
                    ->required(),

                DatePicker::make('start_date')
                    ->label('Дата початку')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Дата завершення')
                    ->required(),
                TextInput::make('name')
                    ->label('Назва дисципліни')
                    ->required(),
                Textarea::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                TextInput::make('credits')
                    ->label('Кредити ЄКТС')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('hours')
                    ->label('Години')
                    ->numeric()
                    ->minValue(0),
                Toggle::make('is_elective')
                    ->label('Вибіркова дисципліна'),
                FileUpload::make('syllabus_url')
                    ->label('Файл силабусу')
                    ->directory('syllabus')
                    ->disk('public')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ])
                    ->maxSize(10240)
                    ->openable()
                    ->downloadable()
                    ->columnSpanFull(),
                Toggle::make('is_published')
                    ->label('Опубліковано')
                    ->default(true),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Id дисципліни')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Назва дисципліни')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Опис дисципліни')
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDisciplines::route('/'),
        ];
    }
}
