<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use App\Filament\Resources\SiteSettings\Components\WorkingHoursField;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('setting_key')
                    ->required()
                    ->disabledOn('edit')
                    ->helperText('Unique identifier for this setting.')
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                // Prevent creation of SMS template settings through SiteSetting resource
                                $smsTemplateKeys = [
                                    'sms_template_otp_en',
                                    'sms_template_otp_ar',
                                    'sms_template_booking_en',
                                    'sms_template_booking_ar',
                                    'sms_template_cancelled_en',
                                    'sms_template_cancelled_ar',
                                ];
                                
                                if (in_array($value, $smsTemplateKeys)) {
                                    $fail('SMS template settings cannot be created or modified through this interface. Please use the Msegat Settings page.');
                                }
                            };
                        },
                    ]),

                TextInput::make('setting_value_capacity')
                    ->label('Maximum Capacity')
                    ->numeric()
                    ->minValue(1)
                    ->required()
                    ->helperText('Maximum number of people allowed per day')
                    ->visible(fn ($get) => $get('setting_key') === 'max_capacity')
                    ->afterStateHydrated(function ($component, $record) {
                        $state = $record->setting_value;
                        if (is_array($state)) {
                            $component->state((int) ($state[0] ?? 200));
                        } else {
                            $component->state((int) $state);
                        }
                    })
                    ->dehydrated(false)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('setting_value', $state)),

                // Working hours setting with improved UI
                WorkingHoursField::make('setting_value_working_hours')
                    ->label('Working Hours')
                    ->columnSpanFull()
                    ->visible(fn ($get) => $get('setting_key') === 'working_hours')
                    ->afterStateHydrated(fn ($component, $record) => $component->state($record->setting_value))
                    ->dehydrated(false)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('setting_value', $state)),

                // Boolean settings (Payment Methods)
                Toggle::make('setting_value_boolean')
                    ->label('Enable Payment Method')
                    ->helperText('Toggle to enable or disable this payment method')
                    ->visible(fn ($get) => in_array($get('setting_key'), ['payment_method_cash', 'payment_method_online']))
                    ->afterStateHydrated(fn ($component, $record) => $component->state((bool) $record->setting_value))
                    ->dehydrated(false)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set) => $set('setting_value', $state)),

                // Text settings (Fallback)
                Textarea::make('setting_value_text')
                    ->label('Value')
                    ->columnSpanFull()
                    ->required()
                    ->helperText('Enter value for this setting')
                    ->visible(fn ($get) => !in_array($get('setting_key'), ['max_capacity', 'working_hours', 'payment_method_cash', 'payment_method_online']))
                    ->afterStateHydrated(function ($component, $record) {
                        $state = $record->setting_value;
                        if (is_array($state) || is_object($state)) {
                            $component->state(json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        } else {
                            $component->state($state);
                        }
                    })
                    ->dehydrated(false)
                    ->lazy()
                    ->afterStateUpdated(fn ($state, $set) => $set('setting_value', $state)),

                // Hidden field to actually save the data
                \Filament\Forms\Components\Hidden::make('setting_value')
                    ->dehydrated(true),
                
                TextInput::make('description')
                    ->helperText('Brief description of what this setting controls'),
            ]);
    }
}
