<?php

namespace App\Filament\Resources\Activitylog\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ActivitylogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('log_name')
                    ->label(__('filament.Log Name'))
                    ->sortable()
                    ->searchable()
                    ->badge(),
                TextColumn::make('description')
                    ->label(__('filament.Description'))
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('subject_type')
                    ->label(__('filament.Subject Type'))
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->sortable()
                    ->color('info'),
                TextColumn::make('subject_id')
                    ->label(__('filament.Subject ID'))
                    ->sortable()
                    ->color('secondary'),
                TextColumn::make('causer.name')
                    ->label(__('filament.User'))
                    ->sortable()
                    ->default(__('filament.Unknown')),
                ViewColumn::make('properties')
                    ->label(__('filament.Changes'))
                    ->view('filament.resources.activitylog.columns.properties'),
                TextColumn::make('created_at')
                    ->label(__('filament.Created At'))
                    ->dateTime()
                    ->sortable()
                    ->color('success')
                    ->icon('heroicon-o-clock'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions
            ])
            ->defaultSort('created_at', 'desc');
    }
}