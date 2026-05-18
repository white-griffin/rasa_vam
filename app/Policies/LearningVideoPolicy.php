<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\LearningVideo;
use Illuminate\Auth\Access\HandlesAuthorization;

class LearningVideoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LearningVideo');
    }

    public function view(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('View:LearningVideo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LearningVideo');
    }

    public function update(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('Update:LearningVideo');
    }

    public function delete(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('Delete:LearningVideo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LearningVideo');
    }

    public function restore(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('Restore:LearningVideo');
    }

    public function forceDelete(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('ForceDelete:LearningVideo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LearningVideo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LearningVideo');
    }

    public function replicate(AuthUser $authUser, LearningVideo $learningVideo): bool
    {
        return $authUser->can('Replicate:LearningVideo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LearningVideo');
    }

}