<?php

namespace App\Filament\Resources\Semesters;

use App\Filament\Resources\Semesters\Pages\CreateSemester;
use App\Filament\Resources\Semesters\Pages\EditSemester;
use App\Filament\Resources\Semesters\Pages\ListSemesters;
use App\Filament\Resources\Semesters\Schemas\SemesterForm;
use App\Filament\Resources\Semesters\Tables\SemestersTable;
use App\Models\Semester;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SemesterResource extends Resource
{
    protected static ?string $model = Semester::class;

    // Іконка в бічному меню (академічна шапка)
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // Локалізація назви на самих сторінках (заголовки, кнопки "Створити...")
    protected static ?string $pluralModelLabel = 'Семестри навчання';

    protected static ?string $modelLabel = 'Семестр навчання';

    // Групування ресурсів у категорію в бічній панелі
    protected static string|UnitEnum|null $navigationGroup = 'Освіта';

    public static function form(Schema $schema): Schema
    {
        return SemesterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SemestersTable::configure($table);
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
            'index' => ListSemesters::route('/'),
            'create' => CreateSemester::route('/create'),
            'edit' => EditSemester::route('/{record}/edit'),
        ];
    }
}
