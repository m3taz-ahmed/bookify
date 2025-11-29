<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Models\Booking;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
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
                TextColumn::make('customer.phone')
                    ->searchable()
                    ->label(__('filament.Customer')),
                TextColumn::make('service.name')
                    ->label(__('filament.Service')),
                TextColumn::make('booking_date')
                    ->date()
                    ->sortable()
                    ->label(__('filament.Booking Date')),
                TextColumn::make('start_time')
                    ->time('g:i A')
                    ->sortable()
                    ->label(__('filament.Start Time')),
                // TextColumn::make('end_time')
                //     ->time('g:i A')
                //     ->sortable()
                //     ->label(__('filament.End Time')),
                TextColumn::make('number_of_people')
                    ->label(__('filament.Number of People')),
                BadgeColumn::make('payment_method')
                    ->colors([
                        'warning' => 'cash',
                        'primary' => 'online',
                    ])
                    ->label(__('filament.Payment Method')),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'confirmed',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->label(__('filament.Status')),
                // TextColumn::make('rating')
                //     ->label(__('filament.Rating')),
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
                Action::make('view_qr')
                    ->label('View QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->modalContent(fn (Booking $record) => view('bookings.qr-code', ['booking' => $record]))
                    ->modalHeading('Booking QR Code')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->hidden(fn (Booking $record) => empty($record->qr_code)),
                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
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