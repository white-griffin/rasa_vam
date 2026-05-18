<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\BankService;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankServicePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:BankService');
    }

    public function view(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('View:BankService');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:BankService');
    }

    public function update(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('Update:BankService');
    }

    public function delete(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('Delete:BankService');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:BankService');
    }

    public function restore(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('Restore:BankService');
    }

    public function forceDelete(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('ForceDelete:BankService');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:BankService');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:BankService');
    }

    public function replicate(AuthUser $authUser, BankService $bankService): bool
    {
        return $authUser->can('Replicate:BankService');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:BankService');
    }

}