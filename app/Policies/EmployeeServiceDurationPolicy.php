<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EmployeeServiceDuration;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeServiceDurationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EmployeeServiceDuration');
    }

    public function view(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('View:EmployeeServiceDuration');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EmployeeServiceDuration');
    }

    public function update(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('Update:EmployeeServiceDuration');
    }

    public function delete(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('Delete:EmployeeServiceDuration');
    }

    public function restore(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('Restore:EmployeeServiceDuration');
    }

    public function forceDelete(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('ForceDelete:EmployeeServiceDuration');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EmployeeServiceDuration');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EmployeeServiceDuration');
    }

    public function replicate(AuthUser $authUser, EmployeeServiceDuration $employeeServiceDuration): bool
    {
        return $authUser->can('Replicate:EmployeeServiceDuration');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EmployeeServiceDuration');
    }

}