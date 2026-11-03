<?php

namespace App\Filament\Resources\Disciplines;

use App\Filament\Resources\Disciplines\Pages\ManageDisciplines;
use App\Models\Discipline;
use BackedEnum;
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
                Select::make('program_id')
                    ->label('Освітня програма')
                    ->relationship('program', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть освітню програму')
                    ->required(),

                // Поле вибору форми навчання
                Select::make('mode_of_study_id')
                    ->label('Форма навчання')
                    ->relationship('modeOfStudy', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть форму навчання')
                    ->required(),

                // Поле вибору семестру
                Select::make('semester_id')
                    ->label('Семестр')
                    ->relationship('semester', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Оберіть семестр')
                    ->required(),

                // Поле вибору курсу навчання
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
                        'application/msword', // .doc
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                    ])
                    ->maxSize(10240)
                    ->openable()      // Додає кнопку для відкриття/перегляду файлу у новій вкладці
                    ->downloadable()  // Додає кнопку для завантаження файлу
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
