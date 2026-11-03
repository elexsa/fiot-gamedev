<?php

namespace App\Filament\Resources\ModeofStudies;

use App\Filament\Resources\ModeofStudies\Pages\CreateModeofStudy;
use App\Filament\Resources\ModeofStudies\Pages\EditModeofStudy;
use App\Filament\Resources\ModeofStudies\Pages\ListModeofStudies;
use App\Filament\Resources\ModeofStudies\Schemas\ModeofStudyForm;
use App\Filament\Resources\ModeofStudies\Tables\ModeofStudiesTable;
use App\Models\ModeofStudy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ModeofStudyResource extends Resource
{
    protected static ?string $model = ModeofStudy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $modelLabel = 'Форма навчання';

    protected static ?string $pluralModelLabel = 'Форми навчання';

    protected static string|UnitEnum|null $navigationGroup = 'Довідники';

    public static function form(Schema $schema): Schema
    {
        return ModeofStudyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModeofStudiesTable::configure($table);
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
            'index' => ListModeofStudies::route('/'),
            'create' => CreateModeofStudy::route('/create'),
            'edit' => EditModeofStudy::route('/{record}/edit'),
        ];
    }
}
