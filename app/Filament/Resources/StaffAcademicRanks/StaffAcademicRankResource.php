<?php

namespace App\Filament\Resources\StaffAcademicRanks;

use App\Filament\Resources\StaffAcademicRanks\Pages\CreateStaffAcademicRank;
use App\Filament\Resources\StaffAcademicRanks\Pages\EditStaffAcademicRank;
use App\Filament\Resources\StaffAcademicRanks\Pages\ListStaffAcademicRanks;
use App\Filament\Resources\StaffAcademicRanks\Schemas\StaffAcademicRankForm;
use App\Filament\Resources\StaffAcademicRanks\Tables\StaffAcademicRanksTable;
use App\Models\StaffAcademicRank;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StaffAcademicRankResource extends Resource
{
    protected static ?string $model = StaffAcademicRank::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BookOpen;

    protected static ?string $pluralModelLabel = 'Вчені звання';

    protected static ?string $modelLabel = 'Вчене звання';

    protected static string|UnitEnum|null $navigationGroup = 'Довідники';

    public static function form(Schema $schema): Schema
    {
        return StaffAcademicRankForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StaffAcademicRanksTable::configure($table);
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
            'index' => ListStaffAcademicRanks::route('/'),
            'create' => CreateStaffAcademicRank::route('/create'),
            'edit' => EditStaffAcademicRank::route('/{record}/edit'),
        ];
    }
}
