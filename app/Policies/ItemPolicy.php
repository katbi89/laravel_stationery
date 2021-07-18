<?php

namespace App\Policies;

use App\User;
use App\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the item.
     *
     * @param  \App\User $user
     * @param  \App\Item $item
     * @return mixed
     */
    public function view(User $user, Item $item)
    {
        return $user->hasPermission('item view');
    }

    /**
     * Determine whether the user can create items.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('item create');
    }

    /**
     * Determine whether the user can update the item.
     *
     * @param  \App\User $user
     * @param  \App\Item $item
     * @return mixed
     */
    public function update(User $user, Item $item)
    {
        return $user->hasPermission('item update');
    }

    /**
     * Determine whether the user can delete the item.
     *
     * @param  \App\User $user
     * @param  \App\Item $item
     * @return mixed
     */
    public function delete(User $user, Item $item)
    {
        return $user->hasPermission('item delete');
    }

    /**
     * Determine whether the user can restore the item.
     *
     * @param  \App\User $user
     * @param  \App\Item $item
     * @return mixed
     */
    public function restore(User $user, Item $item = null)
    {
        return $user->hasPermission('item restore');
    }

    /**
     * Determine whether the user can permanently delete the item.
     *
     * @param  \App\User $user
     * @param  \App\Item $item
     * @return mixed
     */
    public function forceDelete(User $user, Item $item = null)
    {
        return $user->hasPermission('item forceDelete');
    }
}
