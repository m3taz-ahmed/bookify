<?php

namespace App\Filament\Resources\EmployeeServiceDurations\Pages;

use App\Filament\Resources\EmployeeServiceDurations\EmployeeServiceDurationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeServiceDuration extends EditRecord
{
    protected static string $resource = EmployeeServiceDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
