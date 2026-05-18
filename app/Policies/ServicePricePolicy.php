<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ServicePrice;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePricePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ServicePrice');
    }

    public function view(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('View:ServicePrice');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ServicePrice');
    }

    public function update(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('Update:ServicePrice');
    }

    public function delete(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('Delete:ServicePrice');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:ServicePrice');
    }

    public function restore(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('Restore:ServicePrice');
    }

    public function forceDelete(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('ForceDelete:ServicePrice');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ServicePrice');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ServicePrice');
    }

    public function replicate(AuthUser $authUser, ServicePrice $servicePrice): bool
    {
        return $authUser->can('Replicate:ServicePrice');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ServicePrice');
    }

}