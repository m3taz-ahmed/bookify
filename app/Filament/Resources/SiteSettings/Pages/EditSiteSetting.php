<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSiteSetting extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Clear the cache for this specific setting
        if ($this->record && $this->record->setting_key) {
            \Illuminate\Support\Facades\Cache::forget("site_setting_{$this->record->setting_key}");
        }
        
        // Also clear general cache
        \Illuminate\Support\Facades\Cache::forget('site_settings');
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
        // For working_hours setting, the model cast handles it now
        // if (isset($data['setting_key']) && $data['setting_key'] === 'working_hours') {
        //     // Logic removed as model cast handles it
        // }

        return $data;
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Prevent editing SMS template settings
        $smsTemplateKeys = [
            'sms_template_otp_en',
            'sms_template_otp_ar',
            'sms_template_booking_en',
            'sms_template_booking_ar',
            'sms_template_cancelled_en',
            'sms_template_cancelled_ar',
        ];

        if (in_array($this->record->setting_key, $smsTemplateKeys)) {
            Notification::make()
                ->title('Access Denied')
                ->body('SMS template settings cannot be edited through this interface. Please use the Msegat Settings page.')
                ->danger()
                ->send();
                
            $this->redirect(SiteSettingResource::getUrl('index'));
        }
    }
}
