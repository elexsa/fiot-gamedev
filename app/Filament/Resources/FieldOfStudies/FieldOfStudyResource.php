<?php

namespace App\Filament\Resources\FieldOfStudies;

use App\Filament\Resources\FieldOfStudies\Pages\CreateFieldOfStudy;
use App\Filament\Resources\FieldOfStudies\Pages\EditFieldOfStudy;
use App\Filament\Resources\FieldOfStudies\Pages\ListFieldOfStudies;
use App\Filament\Resources\FieldOfStudies\Schemas\FieldOfStudyForm;
use App\Filament\Resources\FieldOfStudies\Tables\FieldOfStudiesTable;
use App\Models\FieldOfStudy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FieldOfStudyResource extends Resource
{
    protected static ?string $model = FieldOfStudy::class;

    // Іконка в бічному меню (академічна шапка)
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // Локалізація назви на самих сторінках (заголовки, кнопки "Створити...")
    protected static ?string $pluralModelLabel = 'Галузі знань';

    protected static ?string $modelLabel = 'Галузь знань';

    // Групування ресурсів у категорію в бічній панелі
    protected static string|UnitEnum|null $navigationGroup = 'Освіта';

    public static function form(Schema $schema): Schema
    {
        return FieldOfStudyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldOfStudiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFieldOfStudies::route('/'),
            'create' => CreateFieldOfStudy::route('/create'),
            'edit' => EditFieldOfStudy::route('/{record}/edit'),
        ];
    }
}
