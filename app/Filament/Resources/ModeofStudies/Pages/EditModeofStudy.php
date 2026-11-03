<?php

namespace App\Filament\Resources\ModeofStudies\Pages;

use App\Filament\Resources\ModeofStudies\ModeofStudyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModeofStudy extends EditRecord
{
    protected static string $resource = ModeofStudyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
