<?php

namespace App;

use App\Http\Requests\Item\StoreItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use SoftDeletes;

    protected $table = 'items';

    protected $fillable = [
        'name', 'description', 'image', 'amount', 'notes', 'tree_id'
    ];

    public static function create($data)
    {
        $treeNode = Tree::findNode($data['name']);

        // update item info
        $item = new Item($data);

        // attach item to node
        $treeNode->item()->save($item);

        // add default unit to item
        $item->units()->create(['name' => 'قطعة', 'capacity' => 1]);

        return $item;
    }

    public function tree()
    {
        return $this->belongsTo('App\Tree');
    }

    public function units()
    {
        return $this->hasMany('App\Unit');
    }

    public function bills()
    {
        return $this->belongsToMany('App\Bill', 'bill_items')->using('App\BillItem')->as('billItem')->withPivot('count', 'cost', 'unit_id');
    }

    public function orders()
    {
        return $this->belongsToMany('App\order', 'order_items')->using('App\orderItem')->as('orderItem')->withPivot('count', 'cost', 'unit_id');
    }

    public function billItems()
    {
        return $this->hasMany('App\BillItem');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function updateAmount() {
        $amount = 0;

        foreach ($this->billItems as $billItem) {
            $amount += $billItem->unit->capacity * $billItem->count;
        }

        foreach ($this->orderItems as $orderItem) {
            $amount -= $orderItem->unit->capacity * $orderItem->count;
        }

        $this->amount = $amount;

        $this->save();

        return $this->amount;
    }
}
