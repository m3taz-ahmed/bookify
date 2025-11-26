<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label(__('filament.Name')),
                TextInput::make('email')
                    ->label(__('filament.Email'))
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label(__('filament.Email Verified At')),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->label(__('filament.Password')),
                Toggle::make('is_active')
                    ->required()
                    ->label(__('filament.Is Active')),
                Select::make('role')
                    ->label(__('filament.Role'))
                    ->options(Role::all()->pluck('name', 'name')->toArray())
                    ->required()
                    ->default('employee'),
            ]);
    }
}