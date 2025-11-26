<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('filament.Name')),
                TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->label(__('filament.Phone')),
            ]);
    }
}