<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerPayment;
use App\Http\Requests\CustomerPayment\StoreCustomerPayment;
use App\Http\Requests\CustomerPayment\UpdateCustomerPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerPaymentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,customerPayment')->only(['show']);
        $this->middleware('can:create,App\CustomerPayment')->only(['create', 'store']);
        $this->middleware('can:update,customerPayment')->only(['edit', 'update']);
        $this->middleware('can:delete,customerPayment')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', CustomerPayment::class)) {
            $data['payments'] = CustomerPayment::withTrashed()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        } else {
            $data['payments'] = CustomerPayment::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        }

        return view('customerPayment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $payment = new CustomerPayment([
            'customer_id' => $customer->id,
            'date' => Carbon::now()->setTimezone(3)->toDateString(),
            'time' => Carbon::now()->setTimezone(3)->toTimeString(),
        ]);

        $data['payment'] = $payment;
        $data['customers'] = Customer::select('id', 'company')->orderBy('company')->pluck('company', 'id');

        return view('customerPayment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerPayment $request)
    {
        DB::beginTransaction();

        $customerPayment = CustomerPayment::create($request->validated());

        $customerPayment->customer->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.customers.show', $customerPayment->customer_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerPayment  $customerPayment
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerPayment $customerPayment)
    {
        $data['payment'] = $customerPayment->loadMissing(['customer']);

        return view('customerPayment.show', $data);
    }

    public function print(CustomerPayment $customerPayment)
    {
        $data['payment'] = $customerPayment->loadMissing(['customer']);

        return view('customerPayment.print', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerPayment  $customerPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerPayment $customerPayment)
    {
        $data['payment'] = $customerPayment;
        $data['customers'] = Customer::select('id', 'company')->orderBy('company')->pluck('company', 'id');

        return view('customerPayment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerPayment  $customerPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerPayment $request, CustomerPayment $customerPayment)
    {
        DB::beginTransaction();

        $customerPayment->update($request->validated());

        $customerPayment->customer->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.customers.show', $customerPayment->customer_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerPayment $customerPayment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(CustomerPayment $customerPayment)
    {
        DB::beginTransaction();

        $customerPayment->delete();

        $customerPayment->customer->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.customerPayments.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(Request $request)
    {
        $customerPayment = CustomerPayment::withTrashed()->find($request->id);

        $this->authorize('restore', $customerPayment);

        DB::beginTransaction();

        $customerPayment->restore();

        $customerPayment->customer->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.customerPayments.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function forceDelete(Request $request)
    {
        $customerPayment = CustomerPayment::withTrashed()->find($request->id);

        $customerPayment->forceDelete();

        return redirect()->route('dashboard.customerPayments.index');
    }
}
