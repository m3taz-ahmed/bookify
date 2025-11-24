<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name_en')
                    ->searchable()
                    ->label(__('Name (English)')),
                TextColumn::make('name_ar')
                    ->searchable()
                    ->label(__('Name (Arabic)')),
                TextColumn::make('duration_minutes')
                    ->numeric()
                    ->sortable()
                    ->label(__('Duration (minutes)')),
                TextColumn::make('price')
                    ->money()
                    ->sortable()
                    ->label(__('Price')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('Is Active')),
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
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->label(__('Sort Order')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                // CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make()
                    ->button(),
            ])
            ->paginated([10, 25, 50, 'all'])
            ->defaultPaginationPageOption(25)
            ->defaultSort('sort_order', 'asc');
    }
}