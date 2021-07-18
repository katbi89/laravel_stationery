<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\Order\StoreOrder;
use App\Http\Requests\Order\UpdateOrder;
use App\Item;
use App\Order;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,order')->only(['show']);
        $this->middleware('can:create,App\Order')->only(['create', 'store']);
        $this->middleware('can:update,order')->only(['edit', 'update']);
        $this->middleware('can:delete,order')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', Order::class)) {
            $data['orders'] = Order::withTrashed()->orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        } else {
            $data['orders'] = Order::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        }

        return view('order.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $order = new Order(['customer_id' => $customer->id, 'date' => date('Y-m-d'), 'time' => date('h:i:s')]);

        $data['order'] = $order;
        $data['items'] = Item::select('id', 'name', 'amount')->with('units')->orderBy('name')->get();
        $data['customers'] = Customer::select('id', 'company')->orderBy('company')->pluck('company', 'id');
        $data['unitsOptions'] = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->id => ['data-capacity' => $unit->capacity, 'data-price' => $unit->price, 'data-item-id' => $unit->item_id]];
        })->all();

        return view('order.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        DB::beginTransaction();

        if (!is_numeric($request->customer_id)) {
            $customer = Customer::create(['company' => $request->customer_id]);

            $request->request->set('customer_id', $customer->id);
        }

        // create new order
        $order = Order::create($request->validated());

        $totalCost = 0;

        foreach ($request->orderItems as $orderItem) {

            $item = null;

            /*
             * number means exist item
             * not number means not exist item
             */
            if (is_numeric($orderItem['item_id'])) {
                // search for item in items
                $item = Item::find($orderItem['item_id']);

                // update item's amount
                $item->amount -= ($orderItem['capacity'] * $orderItem['count']);
                $item->save();
            } else {
                // create new item
                $item = Item::create(['name' => $orderItem['item_id'], 'amount' => (-1) * $orderItem['capacity'] * $orderItem['count']]);
            }
            $unit = null;
            /*
             * number means exist unit
             * not number means not exist unit
             */
            if (is_numeric($orderItem['unit_id'])) {
                // Search for unit in item's units
                $unit = $item->units()->find($orderItem['unit_id']);
            } else {
                // find unit or crete new one if not exist
                $unit = Unit::firstOrCreate(['name' => $orderItem['unit_id'], 'capacity' => $orderItem['capacity'], 'price' => $orderItem['cost'], 'item_id' => $item->id]);

                // attach new unit to item
                $item->units()->save($unit);
            }

            // add item to order
            $order->items()->attach($item, ['cost' => $orderItem['cost'], 'count' => $orderItem['count'], 'unit_id' => $unit->id]);

            // sum subtotal costs
            $totalCost += $orderItem['capacity'] * $orderItem['count'] * $orderItem['cost'];
        }

        // calculate order cost and save
        $order->cost = $totalCost;

        // add new cost to customer's balance
        $order->customer->balance += $totalCost;

        $order->customer->save();
        $order->save();

        DB::commit();

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data['order'] = $order->loadMissing(['orderItems.item', 'orderItems.unit', 'customer']);

        return view('order.show', $data);
    }

    public function print(Order $order)
    {
        $data['order'] = $order->loadMissing(['orderItems.item', 'orderItems.unit', 'customer']);

        return view('order.print', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $data['order'] = $order->loadMissing(['orderItems.item', 'orderItems.unit']);
        $data['items'] = Item::select('id', 'name', 'amount')->with('units')->orderBy('name')->get();
        $data['customers'] = Customer::select('id', 'company')->orderBy('company')->pluck('company', 'id');
        $data['unitsOptions'] = Unit::all()->mapWithKeys(function ($unit) {
            return [$unit->id => ['data-capacity' => $unit->capacity, 'data-price' => $unit->price, 'data-item-id' => $unit->item_id]];
        })->all();
        return view('order.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, Order $order)
    {
        DB::beginTransaction();

        if (!is_numeric($request->customer_id)) {
            $customer = Customer::create(['company' => $request->customer_id]);

            $request->request->set('customer_id', $customer->id);
        }

        $order->update($request->validated());

        $totalCost = 0;

        foreach ($request->orderItems as $orderItem) {

            $item = null;

            /*
             * number means exist item
             * not number means not exist item
             */
            if (is_numeric($orderItem['item_id'])) {

                // search for item in items
                $item = $order->items()->find($orderItem['item_id']);

                if (!$item) {
                    $item = Item::find($orderItem['item_id']);
                }

            } else {

                // create new item
                $item = Item::create(['name' => $orderItem['item_id']]);
            }

            $unit = null;
            /*
             * number means exist unit
             * not number means not exist unit
             */
            if (is_numeric($orderItem['unit_id'])) {
                // search for unit in item's units
                $unit = $item->units()->find($orderItem['unit_id']);
            } else {

                // attach new unit to item
                $unit = $item->units()->create(['name' => $orderItem['unit_id'], 'capacity' => $orderItem['capacity'], 'price' => $orderItem['cost'], 'item_id', $item->id]);

            }

            $oldOrderItem = $order->orderItems()->where('item_id', $item->id)->first();

            if ($oldOrderItem) {
                $oldOrderItem->update(['count' => $orderItem['count'], 'cost' => $orderItem['cost'], 'unit_id' => $unit->id]);
            } else {
                $order->items()->attach($item, ['cost' => $orderItem['cost'], 'count' => $orderItem['count'], 'unit_id' => $unit->id]);
            }

            $totalCost += $orderItem['capacity'] * $orderItem['count'] * $orderItem['cost'];
        }

        // calculate order cost and save
        $order->cost = $totalCost;
        $order->save();

        $order->customer->updateBalance();

        foreach ($order->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();

        $order->delete();

        $order->customer->updateBalance();

        foreach ($order->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.orders.index');
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
        $order = Order::withTrashed()->find($request->id);

        $this->authorize('restore', $order);

        DB::beginTransaction();

        $order->restore();

        $order->customer->updateBalance();

        foreach ($order->items as $item) {
            $item->updateAmount();
        }

        DB::commit();

        return redirect()->route('dashboard.orders.index');
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
        $order = Order::withTrashed()->find($request->id);

        $this->authorize('forceDelete', $order);

        $order->forceDelete();

        return redirect()->route('dashboard.orders.index');
    }
}
