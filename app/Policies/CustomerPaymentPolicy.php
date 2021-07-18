<?php

namespace App\Policies;

use App\User;
use App\CustomerPayment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPaymentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the Customer payment.
     *
     * @param  \App\User  $user
     * @param  \App\CustomerPayment  $CustomerPayment
     * @return mixed
     */
    public function view(User $user, CustomerPayment $CustomerPayment)
    {
        return $user->hasPermission('customerPayment view');
    }

    /**
     * Determine whether the user can create Customer payments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('customerPayment create');
    }

    /**
     * Determine whether the user can update the Customer payment.
     *
     * @param  \App\User  $user
     * @param  \App\CustomerPayment  $CustomerPayment
     * @return mixed
     */
    public function update(User $user, CustomerPayment $CustomerPayment)
    {
        return $user->hasPermission('customerPayment update');
    }

    /**
     * Determine whether the user can delete the Customer payment.
     *
     * @param  \App\User  $user
     * @param  \App\CustomerPayment  $CustomerPayment
     * @return mixed
     */
    public function delete(User $user, CustomerPayment $CustomerPayment)
    {
        return $user->hasPermission('customerPayment delete');
    }

    /**
     * Determine whether the user can restore the Customer payment.
     *
     * @param  \App\User  $user
     * @param  \App\CustomerPayment  $CustomerPayment
     * @return mixed
     */
    public function restore(User $user, CustomerPayment $CustomerPayment = null)
    {
        return $user->hasPermission('customerPayment restore');
    }

    /**
     * Determine whether the user can permanently delete the Customer payment.
     *
     * @param  \App\User  $user
     * @param  \App\CustomerPayment  $CustomerPayment
     * @return mixed
     */
    public function forceDelete(User $user, CustomerPayment $CustomerPayment = null)
    {
        return $user->hasPermission('customerPayment forceDelete');
    }
}
