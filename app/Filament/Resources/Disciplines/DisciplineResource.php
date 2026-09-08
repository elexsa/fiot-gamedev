<?php

namespace App\Filament\Resources\Disciplines;

use App\Filament\Resources\Disciplines\Pages\ManageDisciplines;
use App\Models\Discipline;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DisciplineResource extends Resource
{
    protected static ?string $model = Discipline::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('program_id')
                    ->label('Освітня програма')
                    ->relationship('program', 'name')
                    ->searchable(),
                TextInput::make('name')
                    ->label('Назва дисципліни')
                    ->required(),
                Textarea::make('description')
                    ->label('Опис')
                    ->columnSpanFull(),
                TextInput::make('category')
                    ->label('Категорія')
                    ->placeholder('Математика, Рендер, Ядро GameDev...'),
                Select::make('level')
                    ->label('Рівень (Skill Tree)')
                    ->options([1 => 'Рівень 1 — Фундамент', 2 => 'Рівень 2 — Ядро логіки', 3 => 'Рівень 3 — Ігрові системи', 4 => 'Рівень 4 — Майстерність'])
                    ->default(1)
                    ->required(),
                CheckboxList::make('prerequisites')
                    ->label('Передумови (зв\'язки на дереві)')
                    ->options(fn ($record) => Discipline::where('id', '!=', $record?->id)->orderBy('level')->orderBy('name')->pluck('name', 'id')->all())
                    ->searchable()
                    ->columnSpanFull(),
                Toggle::make('is_boss')
                    ->label('Бос-дисципліна (фінальна)'),
                FileUpload::make('syllabus_file')
                    ->label('Силабус (PDF)')
                    ->directory('syllabus')
                    ->disk('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->columnSpanFull(),
                TextInput::make('syllabus_url')
                    ->label('Або посилання на силабус')
                    ->url()
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Зображення')
                    ->image()
                    ->directory('disciplines')
                    ->disk('public'),
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
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('program.name')
                    ->label('Програма')
                    ->placeholder('—'),
                TextColumn::make('category')
                    ->label('Категорія')
                    ->badge(),
                TextColumn::make('level')
                    ->label('Рівень')
                    ->badge(),
                IconColumn::make('is_boss')
                    ->label('Бос')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Опубліковано')
                    ->boolean(),
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
