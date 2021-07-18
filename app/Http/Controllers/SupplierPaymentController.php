<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierPayment\StoreSupplierPayment;
use App\Http\Requests\SupplierPayment\UpdateSupplierPayment;
use App\Supplier;
use App\SupplierPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,supplierPayment')->only(['show']);
        $this->middleware('can:create,App\SupplierPayment')->only(['create', 'store']);
        $this->middleware('can:update,supplierPayment')->only(['edit', 'update']);
        $this->middleware('can:delete,supplierPayment')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', SupplierPayment::class)) {
            $data['payments'] = SupplierPayment::withTrashed()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        } else {
            $data['payments'] = SupplierPayment::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        }

        return view('supplierPayment.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Supplier $supplier)
    {
        $payment = new SupplierPayment([
            'supplier_id' => $supplier->id,
            'date' => Carbon::now()->setTimezone(3)->toDateString(),
            'time' => Carbon::now()->setTimezone(3)->toTimeString(),
        ]);

        $data['payment'] = $payment;
        $data['suppliers'] = Supplier::select('id', 'company')->orderBy('company')->pluck('company', 'id');

        return view('supplierPayment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierPayment $request)
    {
        DB::beginTransaction();

        $supplierPayment = SupplierPayment::create($request->validated());

        $supplierPayment->supplier->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.suppliers.show', $supplierPayment->supplier_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplierPayment $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPayment $supplierPayment)
    {
        $data['payment'] = $supplierPayment->loadMissing(['supplier']);

        return view('supplierPayment.show', $data);
    }

    public function print(SupplierPayment $supplierPayment)
    {
        $data['payment'] = $supplierPayment->loadMissing(['supplier']);

        return view('supplierPayment.print', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupplierPayment $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierPayment $supplierPayment)
    {
        $data['payment'] = $supplierPayment;
        $data['suppliers'] = Supplier::select('id', 'company')->orderBy('company')->pluck('company', 'id');

        return view('supplierPayment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSupplierPayment $request
     * @param  \App\SupplierPayment $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierPayment $request, SupplierPayment $supplierPayment)
    {
        DB::beginTransaction();

        $supplierPayment->update($request->validated());

        $supplierPayment->supplier->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.suppliers.show', $supplierPayment->supplier_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplierPayment $supplierPayment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(SupplierPayment $supplierPayment)
    {
        DB::beginTransaction();

        $supplierPayment->delete();

        $supplierPayment->supplier->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.supplierPayments.index');
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
        $supplierPayment = SupplierPayment::withTrashed()->find($request->id);

        $this->authorize('restore', $supplierPayment);

        DB::beginTransaction();

        $supplierPayment->restore();

        $supplierPayment->supplier->updateBalance();

        DB::commit();

        return redirect()->route('dashboard.supplierPayments.index');
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
        $supplierPayment = SupplierPayment::withTrashed()->find($request->id);

        $supplierPayment->forceDelete();

        return redirect()->route('dashboard.supplierPayments.index');
    }
}
