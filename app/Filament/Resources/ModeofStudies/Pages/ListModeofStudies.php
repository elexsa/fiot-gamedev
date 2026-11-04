<?php

namespace App\Filament\Resources\ModeofStudies\Pages;

use App\Filament\Resources\ModeofStudies\ModeofStudyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModeofStudies extends ListRecords
{
    protected static string $resource = ModeofStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
