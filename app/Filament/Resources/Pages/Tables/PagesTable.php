<?php

namespace App\Filament\Resources\Pages\Tables;

use App\Models\Page;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Page Type')
                    ->formatStateUsing(fn (string $state): string => Page::getTypes()[$state] ?? ucfirst(str_replace('_', ' ', $state)))
                    ->badge(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('title_en')
                    ->label('Title (English)')
                    ->searchable(),
                TextColumn::make('title_ar')
                    ->label('Title (Arabic)')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
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