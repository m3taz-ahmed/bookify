<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Hash the password
        $data['password'] = Hash::make($data['password']);
        
        return $data;
    }

    protected function afterCreate(): void
    {
        // Assign role to the newly created user
        if (isset($this->data['role'])) {
            $role = Role::where('name', $this->data['role'])->first();
            if ($role) {
                $this->record->assignRole($role);
            }
        }
    }
}