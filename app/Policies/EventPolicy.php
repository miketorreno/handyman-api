<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        return ($user->id == $event->user_id) || ($user->role == User::ADMIN) || ($user->role == User::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return ($user->id == $event->user_id) || ($user->role == User::ADMIN) || ($user->role == User::SUPER_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): bool
    {
        return $user->role == User::SUPER_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): bool
    {
        return $user->role == User::SUPER_ADMIN;
    }

    public function deleteAny(User $user): bool
    {
        return ($user->role == User::ADMIN) || ($user->role == User::SUPER_ADMIN);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->role == User::SUPER_ADMIN;
    }

    public function restoreAny(User $user): bool
    {
        return $user->role == User::SUPER_ADMIN;
    }

    public function reorder(User $user): bool
    {
        return $user->role == User::SUPER_ADMIN;
    }
}
