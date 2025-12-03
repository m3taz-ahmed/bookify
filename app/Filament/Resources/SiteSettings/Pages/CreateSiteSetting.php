<?php

namespace App\Filament\Resources\SiteSettings\Pages;

use App\Filament\Resources\SiteSettings\SiteSettingResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSiteSetting extends CreateRecord
{
    protected static string $resource = SiteSettingResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Prevent creation of SMS template settings
        $smsTemplateKeys = [
            'sms_template_otp_en',
            'sms_template_otp_ar',
            'sms_template_booking_en',
            'sms_template_booking_ar',
            'sms_template_cancelled_en',
            'sms_template_cancelled_ar',
        ];

        if (in_array($data['setting_key'] ?? '', $smsTemplateKeys)) {
            Notification::make()
                ->title(__('filament.creation_failed'))
                ->body(__('filament.sms_template_settings_cannot_be_created_through_this_interface'))
                ->danger()
                ->send();
                
            $this->halt();
        }

        return parent::handleRecordCreation($data);
    }
}