<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Filament\Resources\Bookings\Pages\RescheduleBooking;
use App\Models\Booking;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference_code')
                    ->searchable()
                    ->label(__('Reference Code')),
                TextColumn::make('customer_name')
                    ->searchable()
                    ->label(__('Customer Name')),
                TextColumn::make('customer_phone')
                    ->searchable()
                    ->label(__('Customer Phone')),
                TextColumn::make('service.name_en')
                    ->label(__('Service')),
                TextColumn::make('employee.name')
                    ->label(__('Employee')),
                TextColumn::make('booking_date')
                    ->date()
                    ->sortable()
                    ->label(__('Booking Date')),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable()
                    ->label(__('Start Time')),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable()
                    ->label(__('End Time')),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->label(__('Status')),
                TextColumn::make('payment_status')
                    ->searchable()
                    ->label(__('Payment Status')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Created At')),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('Updated At')),
            ])
            ->filters([
                Filter::make('today')
                    ->label(__('Today'))
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', today());
                    }),
                Filter::make('upcoming')
                    ->label(__('Upcoming'))
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', '>=', today());
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicons-outline-x-circle')
                    ->requiresConfirmation()
                    ->action(function (Booking $record) {
                        $record->cancel();
                    })
                    ->hidden(function (Booking $record) {
                        return $record->status === 'cancelled' || $record->status === 'completed';
                    }),
                Action::make('reschedule')
                    ->label('Reschedule')
                    ->icon('heroicons-outline-calendar')
                    ->url(fn (Booking $record): string => RescheduleBooking::getUrl(['record' => $record->id]))
                    ->hidden(function (Booking $record) {
                        return $record->status === 'cancelled' || $record->status === 'completed';
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}