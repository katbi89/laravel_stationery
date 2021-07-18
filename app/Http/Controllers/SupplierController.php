<?php

namespace App\Http\Controllers;

use App\Http\Requests\Supplier\StoreSupplier;
use App\Http\Requests\Supplier\UpdateSupplier;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,supplier')->only(['show']);
        $this->middleware('can:create,App\Supplier')->only(['create', 'store']);
        $this->middleware('can:update,supplier')->only(['edit', 'update']);
        $this->middleware('can:delete,supplier')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', Supplier::class)) {
            $data['suppliers'] = Supplier::withTrashed()->get();
        } else {
            $data['suppliers'] = Supplier::all();
        }

        return view('supplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['supplier'] = new Supplier();

        return view('supplier.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSupplier $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplier $request)
    {
        $supplier = Supplier::create($request->validated());

        return redirect()->route('dashboard.suppliers.show', $supplier->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        $data['supplier'] = $supplier->loadMissing(['bills', 'payments']);

        $events = collect([]);
        $events = $events->merge($supplier->bills)->merge($supplier->payments);

        $data['events'] = $events->sortByDesc(function ($item, $key) {
            return $item->date . $item->time;
        })->values()->all();

        return view('supplier.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $data['supplier'] = $supplier;

        return view('supplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplier $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return redirect()->route('dashboard.suppliers.show', $supplier->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier $supplier
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('dashboard.suppliers.index');
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
        $supplier = Supplier::withTrashed()->find($request->id);

        $this->authorize('restore', $supplier);

        $supplier->restore();

        return redirect()->route('dashboard.suppliers.index');
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
        $supplier = Supplier::withTrashed()->find($request->id);

        $this->authorize('forceDelete', $supplier);

        $supplier->forceDelete();

        return redirect()->route('dashboard.suppliers.index');
    }
}
