<?php

namespace App\Policies;

use App\Models\User;
use App\Models\YardSale;
use Illuminate\Auth\Access\Response;

class YardSalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, YardSale $yardSale): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, YardSale $yardSale): bool
    {
        return ($user->id == $yardSale->user_id) || ($user->role == User::ROLE_ADMIN) || ($user->role == User::ROLE_SUPER_ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, YardSale $yardSale): bool
    {
        return ($user->id == $yardSale->user_id) || ($user->role == User::ROLE_ADMIN) || ($user->role == User::ROLE_SUPER_ADMIN);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, YardSale $yardSale): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, YardSale $yardSale): bool
    {
        //
    }
}
