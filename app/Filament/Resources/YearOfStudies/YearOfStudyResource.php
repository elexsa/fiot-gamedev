<?php

namespace App\Filament\Resources\YearOfStudies;

use App\Filament\Resources\YearOfStudies\Pages\CreateYearOfStudy;
use App\Filament\Resources\YearOfStudies\Pages\EditYearOfStudy;
use App\Filament\Resources\YearOfStudies\Pages\ListYearOfStudies;
use App\Filament\Resources\YearOfStudies\Schemas\YearOfStudyForm;
use App\Filament\Resources\YearOfStudies\Tables\YearOfStudiesTable;
use App\Models\YearOfStudy;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class YearOfStudyResource extends Resource
{
    protected static ?string $model = YearOfStudy::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;

    protected static ?string $pluralModelLabel = 'Курси навчання';

    protected static ?string $modelLabel = 'Курс навчання';

    protected static string|UnitEnum|null $navigationGroup = 'Довідники';

    public static function form(Schema $schema): Schema
    {
        return YearOfStudyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return YearOfStudiesTable::configure($table);
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
            'index' => ListYearOfStudies::route('/'),
            'create' => CreateYearOfStudy::route('/create'),
            'edit' => EditYearOfStudy::route('/{record}/edit'),
        ];
    }
}
