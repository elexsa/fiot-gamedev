<?php

namespace App\Filament\Resources\Degrees;

use App\Filament\Resources\Degrees\Pages\CreateDegree;
use App\Filament\Resources\Degrees\Pages\EditDegree;
use App\Filament\Resources\Degrees\Pages\ListDegrees;
use App\Filament\Resources\Degrees\Schemas\DegreeForm;
use App\Filament\Resources\Degrees\Tables\DegreesTable;
use App\Models\Degree;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DegreeResource extends Resource
{
    protected static ?string $model = Degree::class;

    // Іконка в бічному меню (академічна шапка)
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // Локалізація назви на самих сторінках (заголовки, кнопки "Створити...")
    protected static ?string $pluralModelLabel = 'Рівні освіти';

    protected static ?string $modelLabel = 'Рівень освіти';

    // Групування ресурсів у категорію в бічній панелі
    protected static string|UnitEnum|null $navigationGroup = 'Освіта';

    public static function form(Schema $schema): Schema
    {
        return DegreeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DegreesTable::configure($table);
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
            'index' => ListDegrees::route('/'),
            'create' => CreateDegree::route('/create'),
            'edit' => EditDegree::route('/{record}/edit'),
        ];
    }
}
