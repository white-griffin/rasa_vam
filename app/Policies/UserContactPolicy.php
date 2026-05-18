<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserContact;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserContactPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserContact');
    }

    public function view(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('View:UserContact');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserContact');
    }

    public function update(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('Update:UserContact');
    }

    public function delete(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('Delete:UserContact');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:UserContact');
    }

    public function restore(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('Restore:UserContact');
    }

    public function forceDelete(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('ForceDelete:UserContact');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UserContact');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UserContact');
    }

    public function replicate(AuthUser $authUser, UserContact $userContact): bool
    {
        return $authUser->can('Replicate:UserContact');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UserContact');
    }

}