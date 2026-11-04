<?php

namespace App\Filament\Resources\StaffAcademicRanks\Pages;

use App\Filament\Resources\StaffAcademicRanks\StaffAcademicRankResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStaffAcademicRank extends EditRecord
{
    protected static string $resource = StaffAcademicRankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
