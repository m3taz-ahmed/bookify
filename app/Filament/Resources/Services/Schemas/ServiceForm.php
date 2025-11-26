<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->required()
                    ->label(__('filament.Name (English)')),
                TextInput::make('name_ar')
                    ->required()
                    ->label(__('filament.Name (Arabic)')),
                Textarea::make('description_en')
                    ->columnSpanFull()
                    ->label(__('filament.Description (English)')),
                Textarea::make('description_ar')
                    ->columnSpanFull()
                    ->label(__('filament.Description (Arabic)')),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->label(__('filament.Price')),
                Toggle::make('is_active')
                    ->required()
                    ->label(__('filament.Is Active')),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label(__('filament.Sort Order')),
            ]);
    }
}