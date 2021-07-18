<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Http\Requests\Bill\StoreBill;
use App\Http\Requests\Bill\UpdateBill;
use App\Item;
use App\Order;
use App\Supplier;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,bill')->only(['show']);
        $this->middleware('can:create,App\Bill')->only(['create', 'store']);
        $this->middleware('can:update,bill')->only(['edit', 'update']);
        $this->middleware('can:delete,bill')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /**
         * if user can force delete bill, so show deleted bills,
         * else show just bills without deleted ones,
         *
         * then return view with data.
         */

        if (auth()->user()->can('forceDelete', Bill::class)) {
            $data['bills'] = Bill::withTrashed()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        } else {
            $data['bills'] = Bill::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        }

        return view('bill.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Supplier $supplier)
    {
        /**
         * first, create new bill with current date and time,
         *
         * get all items with there units to chose bill's items,
         * get all suppliers to chose one of them,
         * get all units options (capacity, item_id),
         *
         * then return view with this data.
         */

        $bill = new Bill(['supplier_id' => $supplier->id, 'date' => date('Y-m-d'), 'time' => date('h:i:s')]);

        $data['bill'] = $bill;
        $data['items'] = Item::select('id', 'name', 'amount')->with('units')->orderBy('name')->get();
        $data['suppliers'] = Supplier::select('id', 'company')->orderBy('company')->pluck('company', 'id');
        $data['unitsOptions'] = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->id => ['data-capacity' => $unit->capacity, 'data-item-id' => $unit->item_id]];
        })->all();

        return view('bill.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBill $request
     * @return array
     */
    public function store(StoreBill $request)
    {
        /**
         * start a transaction,
         *
         * check if supplier is an exist or not, and create one if not exist
         *
         * store the bill in database,
         *
         * foreach bill's items check for item and unit if exist or not, and create one if not exist,
         * to calculate the total cost of bill, sum cost of each bill's item in each loop,
         *
         * save bill total cost and add it to supplier balance and save,
         *
         * finally commit the transaction,
         *
         * return to index page.
         */

        DB::beginTransaction();

        if (!is_numeric($request->supplier_id)) {
            $supplier = Supplier::create(['company' => $request->supplier_id]);

            $request->request->set('supplier_id', $supplier->id);
        }

        // create new bill
        $bill = Bill::create($request->validated());

        $totalCost = 0;

        foreach ($request->billItems as $billItem) {

            $item = null;

            /*
             * number means exist item
             * not number means not exist item
             */
            if (is_numeric($billItem['item_id'])) {
                // search for item in items
                $item = Item::find($billItem['item_id']);

                // update item's amount
                $item->amount += ($billItem['capacity'] * $billItem['count']);
                $item->save();
            } else {
                // create new item
                $item = Item::create(['name' => $billItem['item_id'], 'amount' => $billItem['capacity'] * $billItem['count']]);
            }
            $unit = null;

            /*
             * number means exist unit
             * not number means not exist unit
             */
            if (is_numeric($billItem['unit_id'])) {
                // Search for unit in item's units
                $unit = $item->units()->find($billItem['unit_id']);
            } else {
                // find unit or crete new one if not exist
                $unit = Unit::firstOrCreate(['name' => $billItem['unit_id'], 'capacity' => $billItem['capacity'], 'item_id' => $item->id]);

                // attach new unit to item
                $item->units()->save($unit);
            }
            // add item to bill
            $bill->items()->attach($item, ['cost' => $billItem['cost'], 'count' => $billItem['count'], 'unit_id' => $unit->id]);

            // sum subtotal costs
            $totalCost += $billItem['capacity'] * $billItem['count'] * $billItem['cost'];
        }

        // set total cost
        $bill->cost = $totalCost;

        // add new cost to supplier's balance
        $bill->supplier->balance += $totalCost;

        $bill->supplier->save();
        $bill->save();

        DB::commit();

        return redirect()->route('dashboard.bills.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bill $bill
     * @return Response
     */
    public function show(Bill $bill)
    {
        /**
         * load the missing relations of bill,
         * return view with data.
         */

        $data['bill'] = $bill->loadMissing(['billItems.item', 'billItems.unit', 'supplier']);

        return view('bill.show', $data);
    }

    public function print(Bill $bill)
    {
        /**
         * load the missing relations of bill,
         * return view with data.
         */

        $data['bill'] = $bill->loadMissing(['billItems.item', 'billItems.unit', 'supplier']);

        return view('bill.print', $data);
    }

    public function test(Bill $bill)
    {
        $data['bill'] = $bill->loadMissing(['billItems.item', 'billItems.unit', 'supplier']);

        return view('test', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bill $bill
     * @return Response
     */
    public function edit(Bill $bill)
    {
        /**
         * first, load the missing relations of bill,
         *
         * get all items with there units to chose bill's items,
         * get all suppliers to chose one of them,
         * get all units options (capacity, item_id),
         *
         * then return view with this data.
         */

        $data['bill'] = $bill->loadMissing(['billItems.item', 'billItems.unit']);
        $data['items'] = Item::select('id', 'name', 'amount')->with('units')->orderBy('name')->get();
        $data['suppliers'] = Supplier::select('id', 'company')->orderBy('company')->pluck('company', 'id');
        $data['unitsOptions'] = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->id => ['data-capacity' => $unit->capacity, 'data-item-id' => $unit->item_id]];
        })->all();
        return view('bill.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBill $request
     * @param  \App\Bill $bill
     * @return Response
     */
    public function update(UpdateBill $request, Bill $bill)
    {
        /**
         * start a transaction,
         *
         * check if supplier is an exist or not, and create one if not exist
         *
         * update the bill in database,
         *
         * foreach bill's items check for item and unit if exist or not, and create one if not exist,
         * to calculate the total cost of bill, sum cost of each bill's item in each loop,
         *
         * save bill total cost and add it to supplier balance and save,
         *
         * finally commit the transaction,
         *
         * return to index page.
         */

        DB::beginTransaction();

        if (!is_numeric($request->supplier_id)) {
            $supplier = Supplier::create(['company' => $request->supplier_id]);

            $request->request->set('supplier_id', $supplier->id);
        }

        $bill->update($request->validated());

        $totalCost = 0;

        foreach ($request->billItems as $billItem) {

            $item = null;

            /*
             * number means exist item
             * not number means not exist item
             */
            if (is_numeric($billItem['item_id'])) {

                // search for item in items
                $item = $bill->items()->find($billItem['item_id']);

                if (!$item) {
                    $item = Item::find($billItem['item_id']);
                }

            } else {

                // create new item
                $item = Item::create(['name' => $billItem['item_id']]);
            }

            $unit = null;
            /*
             * number means exist unit
             * not number means not exist unit
             */
            if (is_numeric($billItem['unit_id'])) {
                // search for unit in item's units
                $unit = $item->units()->find($billItem['unit_id']);
            } else {

                // find unit or crete new one if not exist
                $unit = Unit::findOrNew(['name' => $billItem['unit_id'], 'capacity' => $billItem['capacity'], 'item_id' => $item->id]);

                // attach new unit to item
                $item->units()->save($unit);
            }

            $oldBillItem = $bill->billItems()->where('item_id', $item->id)->first();

            if ($oldBillItem) {
                $oldBillItem->update(['count' => $billItem['count'], 'cost' => $billItem['cost'], 'unit_id' => $unit->id]);
            } else {
                $bill->items()->attach($item, ['cost' => $billItem['cost'], 'count' => $billItem['count'], 'unit_id' => $unit->id]);
                $bill;
            }

            $totalCost += $billItem['capacity'] * $billItem['count'] * $billItem['cost'];
        }

        // calculate bill cost and save
        $bill->cost = $totalCost;
        $bill->save();

        $bill->supplier->updateBalance();

        foreach ($bill->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.bills.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bill $bill
     * @return Response
     * @throws \Exception
     */
    public function destroy(Bill $bill)
    {
        DB::beginTransaction();

        $bill->delete();

        $bill->supplier->updateBalance();

        foreach ($bill->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.bills.index');
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
        $bill = Bill::withTrashed()->find($request->id);

        $this->authorize('restore', $bill);

        DB::beginTransaction();

        $bill->restore();

        $bill->supplier->updateBalance();

        foreach ($bill->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.bills.index');
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
        $bill = Bill::withTrashed()->find($request->id);

        $this->authorize('forceDelete', $bill);

        $bill->forceDelete();

        return redirect()->route('dashboard.bills.index');
    }
}
