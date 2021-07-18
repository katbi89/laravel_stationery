<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItem;
use App\Http\Requests\Item\UpdateItem;
use App\Item;
use App\Tree;
use App\Unit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:view,item')->only(['show']);
        $this->middleware('can:create,App\Item')->only(['create', 'store']);
        $this->middleware('can:update,item')->only(['edit', 'update']);
        $this->middleware('can:delete,item')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (auth()->user()->can('forceDelete', Item::class)) {
            $data['items'] = Item::withTrashed()->get();
        } else {
            $data['items'] = Item::all();
        }

        return view('item.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $data['item'] = new Item();

        return view('item.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreItem $request
     * @return RedirectResponse
     */
    public function store(StoreItem $request)
    {
        $item = Item::create($request->validated());

        // check if image has value to update
        if ($request->hasFile('image')) {

            // generate name
            $filename = time() . '.' . $request->image->extension();

            // upload image
            $path = $request->image->storeAs('images', $filename, 'public');

            // save url in database
            $item->image = Storage::url($path);
            $item->save();
        }

        foreach ($request->units as $unit) {
            $item->units()->create([
                'name' => $unit['name'],
                'capacity' => $unit['capacity'],
                'price' => $unit['price']
            ]);
        }

        return redirect()->route('dashboard.items.show', $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item $item
     * @return View
     */
    public function show(Item $item)
    {
        $data['item'] = $item->loadMissing(['units', 'billItems', 'orderItems']);

        $events = collect([]);
        $events = $events->merge($item->bills)->merge($item->orders);

        $data['events'] = $events->sortByDesc(function ($item, $key) {
            return $item->date . $item->time;
        })->values()->all();

        return view('item.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item $item
     * @return View
     */
    public function edit(Item $item)
    {
        $data['item'] = $item;

        return view('item.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateItem $request
     * @param  \App\Item $item
     * @return RedirectResponse
     */
    public function update(UpdateItem $request, Item $item)
    {
        $treeNode = Tree::findNode($request->name);

        // update item info
        $item->update($request->validated());

        // check if image has value to update
        if ($request->hasFile('image')) {

            // generate name
            $filename = time() . '.' . $request->image->extension();

            // upload image
            $path = $request->image->storeAs('images', $filename, 'public');

            // save url in database
            $item->image = Storage::url($path);
        }

        // attach item to node
        $treeNode->item()->save($item);

        foreach ($request->units as $unit) {

            // search for unit in item units
            $u = $item->units()->where('name', $unit['name'])->first();

            if ($u) {
                $u->update(['capacity' => $unit['capacity'], 'price' => $unit['price']]);
            } else {
                // create new unit
                $item->units()->create(['name' => $unit['name'], 'capacity' => $unit['capacity'], 'price' => $unit['price']]);
            }
        }

        return redirect()->route('dashboard.items.show', $item->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item $item
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('dashboard.items.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restore(Request $request)
    {
        $item = Item::withTrashed()->find($request->id);

        $this->authorize('restore', $item);

        $item->restore();

        return redirect()->route('dashboard.items.index');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function forceDelete(Request $request)
    {
        $item = Item::withTrashed()->find($request->id);

        $this->authorize('forceDelete', $item);

        $item->forceDelete();

        return redirect()->route('dashboard.items.index');
    }
}
