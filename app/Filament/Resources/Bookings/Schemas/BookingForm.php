<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Filament\Resources\Bookings\Components\WorkingDaysDatePicker;
use App\Filament\Resources\Bookings\Components\WorkingHoursTimePicker;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Radio;
use Filament\Support\HtmlString;
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
                    ->label(__('filament.Customer'))
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->label(__('filament.Name')),
                        TextInput::make('phone')
                            ->required()
                            ->unique()
                            ->tel()
                            ->label(__('filament.Phone')),
                    ])
                    ->createOptionUsing(function (array $data) {
                        return \App\Models\Customer::create($data)->id;
                    })
                    ->getOptionLabelFromRecordUsing(fn (\App\Models\Customer $record) => "{$record->name} ({$record->phone})"),

                \Filament\Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->schema([
                        Select::make('service_id')
                            ->relationship('service', 'name_en')
                            ->getOptionLabelFromRecordUsing(fn (Service $record) => app()->getLocale() === 'ar' ? $record->name_ar : $record->name_en)
                            ->required()
                            ->label(__('filament.Service'))
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $service = Service::find($state);
                                $price = $service?->price ?? 0;
                                $set('unit_price', $price);
                                $set('total_price', $price * intval($get('quantity') ?? 1));
                            }),
                        TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->label(__('filament.Quantity'))
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $unitPrice = $get('unit_price') ?? 0;
                                $set('total_price', $unitPrice * intval($state));
                            }),
                        \Filament\Forms\Components\Hidden::make('unit_price')
                            ->default(0),
                        \Filament\Forms\Components\Hidden::make('total_price')
                            ->default(0),
                    ])
                    ->columns(2)
                    ->label(__('filament.Tickets'))
                    ->live()
                    ->afterStateUpdated(function (callable $get, callable $set) {
                        $items = $get('items') ?? [];
                        $totalPeople = 0;
                        foreach ($items as $item) {
                            $totalPeople += intval($item['quantity'] ?? 0);
                        }
                        $set('number_of_people', $totalPeople > 0 ? $totalPeople : 1);
                    }),
                    
                WorkingDaysDatePicker::make('booking_date')
                    ->required()
                    ->label(__('filament.Booking Date'))
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Reset time field when date changes
                        $set('start_time', null);
                    }),
                // TextInput::make('payment_status')
                //     ->label(__('filament.Payment Status')),
                WorkingHoursTimePicker::make('start_time')
                    // ->required()
                    ->label(__('filament.Start Time'))
                    ->dateField('booking_date')
                    ->disabled(fn (callable $get) => !$get('booking_date')),
                    
                Hidden::make('number_of_people')
                    ->default(1)
                    ->required()
                    ->rules([
                        'required',
                        'integer',
                        'min:1',
                        'max:100',
                    ]),
                Select::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'online' => 'Online',
                    ])
                    ->label(__('filament.Payment Method'))
                    ->required(),
                Radio::make('status')
                    ->options([
                        'pending' => __('filament.Pending'),
                        'confirmed' => __('filament.Confirmed'),
                        'completed' => __('filament.Completed'),
                        'cancelled' => __('filament.Cancelled'),
                    ])
                    ->default('pending')
                    ->required()
                    ->label(__('filament.Status'))
                    ->columns(4)
                    ->columnSpanFull(),
                Placeholder::make('qr_code')
                    ->label(__('filament.QR Code'))
                    ->content(fn ($record) => $record && $record->qr_code ? '<img src="' . $record->qr_code . '" alt="QR Code" style="max-width: 200px;">' : __('filament.No QR Code generated yet'))
                    ->visible(fn ($record) => $record !== null),
                
            ]);
    }
}