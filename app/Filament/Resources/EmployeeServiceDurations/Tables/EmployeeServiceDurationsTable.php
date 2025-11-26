<?php

namespace App\Filament\Resources\EmployeeServiceDurations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EmployeeServiceDurationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.name')
                    ->label(__('filament.Employee'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('service.name_ar')
                    ->label(__('filament.Service'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('duration')
                    ->label(__('filament.Duration (minutes)'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}