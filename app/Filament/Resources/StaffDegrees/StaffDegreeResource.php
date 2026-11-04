<?php

namespace App\Filament\Resources\StaffDegrees;

use App\Filament\Resources\StaffDegrees\Pages\CreateStaffDegree;
use App\Filament\Resources\StaffDegrees\Pages\EditStaffDegree;
use App\Filament\Resources\StaffDegrees\Pages\ListStaffDegrees;
use App\Filament\Resources\StaffDegrees\Schemas\StaffDegreeForm;
use App\Filament\Resources\StaffDegrees\Tables\StaffDegreesTable;
use App\Models\StaffDegree;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StaffDegreeResource extends Resource
{
    protected static ?string $model = StaffDegree::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?string $pluralModelLabel = 'Наукові ступені';

    protected static ?string $modelLabel = 'Науковий ступінь';

    protected static string|UnitEnum|null $navigationGroup = 'Довідники';

    public static function form(Schema $schema): Schema
    {
        return StaffDegreeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaffDegreesTable::configure($table);
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
            'index' => ListStaffDegrees::route('/'),
            'create' => CreateStaffDegree::route('/create'),
            'edit' => EditStaffDegree::route('/{record}/edit'),
        ];
    }
}
