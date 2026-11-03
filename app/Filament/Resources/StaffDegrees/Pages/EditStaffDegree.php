<?php

namespace App\Filament\Resources\StaffDegrees\Pages;

use App\Filament\Resources\StaffDegrees\StaffDegreeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaffDegree extends EditRecord
{
    protected static string $resource = StaffDegreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
