<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Customer\StoreCustomer;
use App\Http\Requests\Customer\UpdateCustomer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,customer')->only(['show']);
        $this->middleware('can:create,App\Customer')->only(['create', 'store']);
        $this->middleware('can:update,customer')->only(['edit', 'update']);
        $this->middleware('can:delete,customer')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', Customer::class)) {
            $data['customers'] = Customer::withTrashed()->get();
        } else {
            $data['customers'] = Customer::all();
        }

        return view('customer.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['customer'] = new Customer();

        return view('customer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $customer = Customer::create($request->validated());

        return redirect()->route('dashboard.customers.show', $customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $data['customer'] = $customer->loadMissing(['orders', 'payments']);

        $events = collect([]);
        $events = $events->merge($customer->orders)->merge($customer->payments);

        $data['events'] = $events->sortByDesc(function ($item, $key) {
            return $item->date . $item->time;
        })->values()->all();

        return view('customer.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $data['customer'] = $customer;

        return view('customer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()->route('dashboard.customers.show', $customer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('dashboard.customers.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(Request $request)
    {
        $customer = Customer::withTrashed()->find($request->id);

        $this->authorize('restore', $customer);

        $customer->restore();

        return redirect()->route('dashboard.customers.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function forceDelete(Request $request)
    {
        $customer = Customer::withTrashed()->find($request->id);

        $this->authorize('forceDelete', $customer);

        $customer->forceDelete();

        return redirect()->route('dashboard.customers.index');
    }
}
