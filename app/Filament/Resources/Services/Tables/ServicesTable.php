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
                    ->label(__('filament.Name (English)')),
                TextColumn::make('name_ar')
                    ->searchable()
                    ->label(__('filament.Name (Arabic)')),
                // TextColumn::make('description_en')
                //     ->searchable()
                //     ->label(__('filament.Description (English)'))
                //     ->limit(50),
                // TextColumn::make('description_ar')
                //     ->searchable()
                //     ->label(__('filament.Description (Arabic)'))
                //     ->limit(50),
                TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => 'SAR ' . number_format($state, 2))
                    ->sortable()
                    ->label(__('filament.Price')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('filament.Is Active')),
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
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->label(__('filament.Sort Order')),
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