<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use SoftDeletes;

    protected $table = 'bills';

    protected $fillable = [
        'order_id','cost', 'date', 'time', 'notes', 'supplier_id'
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function items()
    {
        return $this->belongsToMany('App\Item', 'bill_items')->using('App\BillItem')->as('billItem')->withPivot('count', 'cost', 'unit_id');
    }

    public function billItems()
    {
        return $this->hasMany('App\BillItem');
    }

    public function updateCost() {
        $cost = 0;

        foreach ($this->billItems as $billItem) {
            $cost += $billItem->unit->capacity * $billItem->count * $billItem->cost;
        }
        $this->cost = $cost;

        $this->save();

        return $this->cost;
    }
}
