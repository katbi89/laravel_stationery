<?php

namespace App\Policies;

use App\User;
use App\SupplierPayment;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPaymentPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the supplier payment.
     *
     * @param  \App\User  $user
     * @param  \App\SupplierPayment  $supplierPayment
     * @return mixed
     */
    public function view(User $user, SupplierPayment $supplierPayment)
    {
        return $user->hasPermission('supplierPayment view');
    }

    /**
     * Determine whether the user can create supplier payments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('supplierPayment create');
    }

    /**
     * Determine whether the user can update the supplier payment.
     *
     * @param  \App\User  $user
     * @param  \App\SupplierPayment  $supplierPayment
     * @return mixed
     */
    public function update(User $user, SupplierPayment $supplierPayment)
    {
        return $user->hasPermission('supplierPayment update');
    }

    /**
     * Determine whether the user can delete the supplier payment.
     *
     * @param  \App\User  $user
     * @param  \App\SupplierPayment  $supplierPayment
     * @return mixed
     */
    public function delete(User $user, SupplierPayment $supplierPayment)
    {
        return $user->hasPermission('supplierPayment delete');
    }

    /**
     * Determine whether the user can restore the supplier payment.
     *
     * @param  \App\User  $user
     * @param  \App\SupplierPayment  $supplierPayment
     * @return mixed
     */
    public function restore(User $user, SupplierPayment $supplierPayment = null)
    {
        return $user->hasPermission('supplierPayment restore');
    }

    /**
     * Determine whether the user can permanently delete the supplier payment.
     *
     * @param  \App\User  $user
     * @param  \App\SupplierPayment  $supplierPayment
     * @return mixed
     */
    public function forceDelete(User $user, SupplierPayment $supplierPayment = null)
    {
        return $user->hasPermission('supplierPayment forceDelete');
    }
}
