<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reference_code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->label(__('filament.Reference Code'))
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn ($context) => $context === 'edit'),
                Select::make('customer_id')
                    ->relationship('customer', 'phone')
                    ->required()
                    ->searchable()
                    ->label(__('filament.Customer')),
                Select::make('service_id')
                    ->relationship('service', 'name_en')
                    ->required()
                    ->label(__('filament.Service')),
                DatePicker::make('booking_date')
                    ->required()
                    ->label(__('filament.Booking Date')),
                TimePicker::make('start_time')
                    ->required()
                    ->seconds(false)
                    ->label(__('filament.Start Time')),
                TimePicker::make('end_time')
                    ->required()
                    ->seconds(false)
                    ->label(__('filament.End Time')),
                Radio::make('status')
                    ->options([
                        'pending' => __('filament.Pending'),
                        'confirmed' => __('filament.Confirmed'),
                        'completed' => __('filament.Completed'),
                        'cancelled' => __('filament.Cancelled'),
                    ])
                    ->default('pending')
                    ->required()
                    ->label(__('filament.Status')),
                TextInput::make('payment_status')
                    ->label(__('filament.Payment Status')),
            ]);
    }
}