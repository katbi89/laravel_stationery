<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BillItem extends Pivot
{
    protected $table = 'bill_items';

    protected $fillable = [
        'count', 'cost', 'unit_id', 'item_id', 'bill_id'
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    public function bill()
    {
        return $this->belongsTo('App\Bill');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }
}
