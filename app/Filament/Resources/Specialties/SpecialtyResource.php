<?php

namespace App\Filament\Resources\Specialties;

use App\Filament\Resources\Specialties\Pages\CreateSpecialty;
use App\Filament\Resources\Specialties\Pages\EditSpecialty;
use App\Filament\Resources\Specialties\Pages\ListSpecialties;
use App\Filament\Resources\Specialties\Schemas\SpecialtyForm;
use App\Filament\Resources\Specialties\Tables\SpecialtiesTable;
use App\Models\Specialty;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class SpecialtyResource extends Resource
{
    protected static ?string $model = Specialty::class;

    // Іконка в бічному меню (академічна шапка)
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // Локалізація назви на самих сторінках (заголовки, кнопки "Створити...")
    protected static ?string $pluralModelLabel = 'Спеціальності';

    protected static ?string $modelLabel = 'Спеціальність';

    // Групування ресурсів у категорію в бічній панелі
    protected static string|UnitEnum|null $navigationGroup = 'Освіта';

    public static function form(Schema $schema): Schema
    {
        return SpecialtyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SpecialtiesTable::configure($table);
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
            'index' => ListSpecialties::route('/'),
            'create' => CreateSpecialty::route('/create'),
            'edit' => EditSpecialty::route('/{record}/edit'),
        ];
    }
}
