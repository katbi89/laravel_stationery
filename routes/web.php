<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
        /**
         * Dashboard Routes
         */
        Route::get('/', 'DashboardController@index')->name('index');

        /**
         * Tree Routes
         */
        Route::resource('trees', 'TreeController');

        /**
         * Items Routes
         */
        Route::post('items/restore/{id}', 'ItemController@restore')->name('items.restore');
        Route::post('items/forceDelete/{id}', 'ItemController@forceDelete')->name('items.forceDelete');
        Route::resource('items/{item}/units', 'UnitController');
        Route::resource('items', 'ItemController');

        /**
         * Supplier Routes
         */
        Route::post('suppliers/restore/{id}', 'SupplierController@restore')->name('suppliers.restore');
        Route::post('suppliers/forceDelete/{id}', 'SupplierController@forceDelete')->name('suppliers.forceDelete');
        Route::get('suppliers/{supplier}/bills/create', 'BillController@create')->name('suppliers.bills.create');
        Route::post('suppliers/{supplier}/bills/', 'BillController@store')->name('suppliers.bills.store');
        Route::get('suppliers/{supplier}/payments/create', 'SupplierPaymentController@create')->name('suppliers.payments.create');
        Route::post('suppliers/{supplier}/payments/', 'SupplierPaymentController@store')->name('suppliers.payments.store');
        Route::resource('suppliers', 'SupplierController');

        /**
         * Bill Routes
         */
        Route::post('bills/restore/{id}', 'BillController@restore')->name('bills.restore');
        Route::post('bills/forceDelete/{id}', 'BillController@forceDelete')->name('bills.forceDelete');
        Route::get('bills/{bill}/print/', 'BillController@print')->name('bills.print');
        Route::get('bills/{bill}/test/', 'BillController@test')->name('bills.print');
        Route::resource('bills', 'BillController');

        /**
         * Supplier Payment
         */
        Route::post('supplierPayments/restore/{id}', 'SupplierPaymentController@restore')->name('supplierPayments.restore');
        Route::post('supplierPayments/forceDelete/{id}', 'SupplierPaymentController@forceDelete')->name('supplierPayments.forceDelete');
        Route::get('supplierPayments/{supplierPayment}/print/', 'SupplierPaymentController@print')->name('supplierPayments.print');
        Route::resource('supplierPayments', 'SupplierPaymentController');

        /**
         * Customer Routes
         */
        Route::post('customers/restore/{id}', 'CustomerController@restore')->name('customers.restore');
        Route::post('customers/forceDelete/{id}', 'CustomerController@forceDelete')->name('customers.forceDelete');
        Route::get('customers/{customer}/orders/create', 'OrderController@create')->name('customers.orders.create');
        Route::post('customers/{customer}/orders/', 'OrderController@store')->name('customers.orders.store');
        Route::get('customers/{customer}/payments/create', 'CustomerPaymentController@create')->name('customers.payments.create');
        Route::post('customers/{customer}/payments/', 'CustomerPaymentController@store')->name('customers.payments.store');
        Route::resource('customers', 'CustomerController');

        /**
         * Order Routes
         */
        Route::post('orders/restore/{id}', 'OrderController@restore')->name('orders.restore');
        Route::post('orders/forceDelete/{id}', 'OrderController@forceDelete')->name('orders.forceDelete');
        Route::get('orders/{order}/print/', 'OrderController@print')->name('orders.print');
        Route::resource('orders', 'OrderController');

        /**
         * Customer Payment
         */
        Route::post('customerPayments/restore/{id}', 'CustomerPaymentController@restore')->name('customerPayments.restore');
        Route::post('customerPayments/forceDelete/{id}', 'CustomerPaymentController@forceDelete')->name('customerPayments.forceDelete');
        Route::get('customerPayments/{customerPayment}/print/', 'CustomerPaymentController@print')->name('customerPayments.print');
        Route::resource('customerPayments', 'CustomerPaymentController');

    });

    Auth::routes(['register' => false]);

    Route::get('/home', 'HomeController@index')->name('home');
});


