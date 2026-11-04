<?php

namespace App\Filament\Resources\StaffDegrees\Pages;

use App\Filament\Resources\StaffDegrees\StaffDegreeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStaffDegrees extends ListRecords
{
    protected static string $resource = StaffDegreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
