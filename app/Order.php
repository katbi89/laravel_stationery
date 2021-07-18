<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'cost', 'date', 'time', 'notes', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'order_items')->using('App\OrderItem')->as('orderItem')->withPivot('count', 'cost', 'unit_id');
    }

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function updateCost() {
        $cost = 0;

        foreach ($this->orderItems as $orderItem) {
            $cost += $orderItem->unit->capacity * $orderItem->count * $orderItem->cost;
        }
        $this->cost = $cost;

        $this->save();

        return $this->cost;
    }
}
