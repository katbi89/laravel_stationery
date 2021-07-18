<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    protected $table = 'order_items';

    protected $fillable = [
        'count', 'cost', 'unit_id', 'item_id', 'order_id'
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
