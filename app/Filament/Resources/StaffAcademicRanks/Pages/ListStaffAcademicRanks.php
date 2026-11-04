<?php

namespace App\Filament\Resources\StaffAcademicRanks\Pages;

use App\Filament\Resources\StaffAcademicRanks\StaffAcademicRankResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStaffAcademicRanks extends ListRecords
{
    protected static string $resource = StaffAcademicRankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
