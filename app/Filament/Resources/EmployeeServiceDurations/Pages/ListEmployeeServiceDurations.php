<?php

namespace App\Filament\Resources\EmployeeServiceDurations\Pages;

use App\Filament\Resources\EmployeeServiceDurations\EmployeeServiceDurationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeServiceDurations extends ListRecords
{
    protected static string $resource = EmployeeServiceDurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
