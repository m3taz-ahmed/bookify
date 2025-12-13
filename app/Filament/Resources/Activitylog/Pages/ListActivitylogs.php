<?php

namespace App\Filament\Resources\Activitylog\Pages;

use App\Filament\Resources\Activitylog\ActivitylogResource;
use Filament\Resources\Pages\ListRecords;

class ListActivitylogs extends ListRecords
{
    protected static string $resource = ActivitylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No actions as we don't want to allow creating new records
        ];
    }
}