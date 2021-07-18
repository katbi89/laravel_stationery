<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Item' => 'App\Policies\ItemPolicy',
        'App\Supplier' => 'App\Policies\SupplierPolicy',
        'App\Bill' => 'App\Policies\BillPolicy',
        'App\SupplierPayment' => 'App\Policies\SupplierPaymentPolicy',
        'App\Customer' => 'App\Policies\CustomerPolicy',
        'App\Order' => 'App\Policies\OrderPolicy',
        'App\CustomerPayment' => 'App\Policies\CustomerPaymentPolicy',

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
