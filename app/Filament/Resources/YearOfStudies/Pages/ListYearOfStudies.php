<?php

namespace App\Filament\Resources\YearOfStudies\Pages;

use App\Filament\Resources\YearOfStudies\YearOfStudyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListYearOfStudies extends ListRecords
{
    protected static string $resource = YearOfStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
