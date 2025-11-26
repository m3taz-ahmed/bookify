<?php

namespace App\Filament\Resources\Shifts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ShiftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('filament.Employee'))
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('day_of_week')
                    ->label(__('filament.Day'))
                    ->formatStateUsing(fn (int $state): string => match ($state) {
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        0 => 'Sunday',
                        default => 'Unknown',
                    })
                    ->sortable(),
                
                TextColumn::make('start_time')
                    ->label(__('filament.Start Time'))
                    ->time()
                    ->sortable(),
                
                TextColumn::make('end_time')
                    ->label(__('filament.End Time'))
                    ->time()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('day_of_week')
                    ->label(__('filament.Day of Week'))
                    ->options([
                        1 => 'Monday',
                        2 => 'Tuesday',
                        3 => 'Wednesday',
                        4 => 'Thursday',
                        5 => 'Friday',
                        6 => 'Saturday',
                        0 => 'Sunday',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}