<?php

namespace App\Filament\Resources\YearOfStudies\Pages;

use App\Filament\Resources\YearOfStudies\YearOfStudyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditYearOfStudy extends EditRecord
{
    protected static string $resource = YearOfStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
