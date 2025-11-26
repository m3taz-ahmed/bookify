<?php

namespace App\Filament\Resources\Bookings\Tables;

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
                    ->label(__('filament.Reference Code')),
                TextColumn::make('customer_name')
                    ->searchable()
                    ->label(__('filament.Customer Name')),
                TextColumn::make('customer_phone')
                    ->searchable()
                    ->label(__('filament.Customer Phone')),
                TextColumn::make('service.name_en')
                    ->label(__('filament.Service')),
                TextColumn::make('employee.name')
                    ->label(__('filament.Employee')),
                TextColumn::make('booking_date')
                    ->date()
                    ->sortable()
                    ->label(__('filament.Booking Date')),
                TextColumn::make('start_time')
                    ->time()
                    ->sortable()
                    ->label(__('filament.Start Time')),
                TextColumn::make('end_time')
                    ->time()
                    ->sortable()
                    ->label(__('filament.End Time')),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->label(__('filament.Status')),
                TextColumn::make('payment_status')
                    ->searchable()
                    ->label(__('filament.Payment Status')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('filament.Created At')),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('filament.Updated At')),
            ])
            ->filters([
                Filter::make('today')
                    ->label(__('filament.Today'))
                    ->query(function (Builder $query) {
                        return $query->whereDate('booking_date', today());
                    }),
                Filter::make('upcoming')
                    ->label(__('filament.Upcoming'))
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}