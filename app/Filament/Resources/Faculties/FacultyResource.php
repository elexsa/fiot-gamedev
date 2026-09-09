<?php

namespace App\Filament\Resources\Faculties;

use App\Filament\Resources\Faculties\Pages\ManageFaculties;
use App\Models\Faculty;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FacultyResource extends Resource
{
    protected static ?string $model = Faculty::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('ПІБ')
                    ->required(),
                TextInput::make('role')
                    ->label('Посада / звання'),
                Textarea::make('focus')
                    ->label('Напрямки роботи')
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->label('Фото')
                    ->image()
                    ->directory('faculty')
                    ->disk('public')
                    ->visibility('public'),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
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
                ImageColumn::make('photo')
                    ->label('Фото')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('ПІБ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->label('Посада'),
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
            'index' => ManageFaculties::route('/'),
        ];
    }
}
