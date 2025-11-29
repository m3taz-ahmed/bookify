<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // For max_capacity setting, ensure we load the actual value from database
        // if (isset($data['setting_key']) && $data['setting_key'] === 'max_capacity') {
        //     $actualValue = SiteSetting::where('setting_key', 'max_capacity')->value('setting_value');
        //     if ($actualValue !== null) {
        //         // Value is stored as integer in DB, but cast as array due to model casting
        //         // Extract the actual integer value
        //         if (is_array($actualValue)) {
        //             $data['setting_value'] = (int) ($actualValue[0] ?? 200);
        //         } else {
        //             $data['setting_value'] = (int) $actualValue;
        //         }
        //     }
        // }
        
        // For working_hours setting, ensure we load the actual value from database
        if (isset($data['setting_key']) && $data['setting_key'] === 'working_hours') {
            $actualValue = SiteSetting::where('setting_key', 'working_hours')->value('setting_value');
            if ($actualValue !== null) {
                // Since setting_value is cast as array, we need to handle it properly
                if (is_array($actualValue)) {
                    $data['setting_value'] = $actualValue;
                } else {
                    // Decode JSON string if needed
                    $decoded = json_decode($actualValue, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $data['setting_value'] = $decoded;
                    } else {
                        $data['setting_value'] = [];
                    }
                }
            }
        }

        return $data;
    }
}
