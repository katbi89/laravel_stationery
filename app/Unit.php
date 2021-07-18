<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table = 'units';

    protected $fillable = [
        'name', 'capacity', 'price', 'item_id',
    ];

    public function item()
    {
        return $this->belongsTo('App\Item');
    }
}
